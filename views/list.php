<?php

# Prolog

if (!defined('CONTEXT')) {
    require '../config.php';
    header('Location: ' . ROOT);
    exit();
}

echo '<div class="content" type="large">';
echo '<h1>'.$title.'</h1>';

$events = scanFolder(DATA, ['media', '..', '.']);
if ($events) {
    foreach ($events as $event) {
        $ev = new Event();
        $ev->read($event);
        $event_list[] = $ev->event;
    }
    usort($event_list, 'compare_eventdate');

    foreach ($event_list as $ev) {
        echo '<h3>'.$ev['event_date'].'</h3>'.PHP_EOL;
        echo '<h2>'.$ev['event'].' ['.$ev['genre'].']</h2>'.PHP_EOL;
        echo '<p>'.nl2br($ev['plot']).'</p>'.PHP_EOL;
        if (!empty($ev['web'])) {
            echo '<a href="'.$ev['web'].'" target="_new">'.$ev['web'].'</a>'.PHP_EOL;
        }
        echo '<hr>'.PHP_EOL;
        echo 'Stream: ';
        echo empty($ev['stream']) ? 'k.A. <span style="color: red; font-size: 1.2em;">&#9998;</span>'.PHP_EOL : $ev['stream'].PHP_EOL;
        if ($ev['permalink']) {
            echo '<br>Permalink'.PHP_EOL;
        } else {
            echo '<br>gültig ab: ';
            echo empty($ev['from']) ? 'k.A'.PHP_EOL : $ev['from'].PHP_EOL;
            echo ' bis: ';
            echo empty($ev['to']) ? 'k.A'.PHP_EOL : $ev['to'].PHP_EOL;
        }
        echo '<hr>'.PHP_EOL;
        echo 'Icon: ';
        echo empty($ev['icon']) ? 'k.A'.PHP_EOL : '<a href="'.$ev['icon']. '" target="_blank">' .$ev['icon'].'</a>'.PHP_EOL;
        echo '<br>Poster: ';
        echo empty($ev['fanart']) ? 'k.A'.PHP_EOL : '<a href="'.$ev['fanart']. '" target="_blank">' .$ev['fanart'].'</a>'.PHP_EOL;
        echo '<p class="small">erstellt von '.$ev['user'].'</p>'.PHP_EOL;
        echo '<form name="'.$ev['id'].'" id="'.$ev['id'].'" action="'.CONTROLLER.'" method="POST">';
        if (empty($ev['stream']) and !$ev->$event['permalink']) {
            echo '<input type="hidden" name="stream" id="stream" value="">'.PHP_EOL;
            echo '<input class="button" type="button" value="Stream eintragen" name="edit_stream" onclick="fPrompt('.$ev['id'].')">'.PHP_EOL;
        }
        if ($ev['user_id'] == $_SESSION['id']) {
            echo '<input class="button" type="submit" value="Bearbeiten" name="edit">'.PHP_EOL;
            echo '<input class="button_red" type="submit" value="Löschen" name="delete" onclick="return fConfirm()">'.PHP_EOL;
            echo '<input type="hidden" name="item" value="'.$ev['id'].'">'.PHP_EOL;
        }
        echo '</form>';
    }
    echo '<hr>'.PHP_EOL;
}
?>

<form name="n" id="n" action="<?php echo CONTROLLER; ?>" method="post">
    <input type="submit" class="button" name="add" value="Hinzufügen">
    <input type="hidden" name="site" value="collect_event">
</form>
</div>

