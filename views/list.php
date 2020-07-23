<?php

# Prolog

if (!defined('CONTEXT')) {
    require 'start.php';
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
        echo '<h3>'.$ev->event['event_date'].'</h3>'.PHP_EOL;
        echo '<h2>'.$ev->event['event'].' ['.$ev->event['genre'].']</h2>'.PHP_EOL;
        echo '<p>'.nl2br($ev->event['plot']).'</p>'.PHP_EOL;
        echo '<hr>'.PHP_EOL;
        echo 'Stream: ';
        echo empty($ev->event['stream']) ? 'k.A.'.PHP_EOL : $ev->event['stream'].PHP_EOL;
        if ($ev->event['permalink']) {
            echo '<br>Permalink'.PHP_EOL;
        } else {
            echo '<br>gültig ab: ';
            echo empty($ev->event['from']) ? 'k.A'.PHP_EOL : $ev->event['from'].PHP_EOL;
            echo ' bis: ';
            echo empty($ev->event['to']) ? 'k.A'.PHP_EOL : $ev->event['to'].PHP_EOL;
        }
        echo '<hr>'.PHP_EOL;
        echo 'Icon: ';
        echo empty($ev->event['icon']) ? 'k.A'.PHP_EOL : '<a href="'.$ev->event['icon']. '" target="_blank">' .$ev->event['icon'].'</a>'.PHP_EOL;
        echo '<br>Poster: ';
        echo empty($ev->event['fanart']) ? 'k.A'.PHP_EOL : '<a href="'.$ev->event['fanart']. '" target="_blank">' .$ev->event['fanart'].'</a>'.PHP_EOL;
        if ($ev->event['user_id'] == $_SESSION['id']) {
            echo '<br>'.PHP_EOL;
            echo '<form name="n" id="n" action="'.CONTROLLER.'" method="POST">';
            echo '<input class="button" type="submit" value="Bearbeiten" name="edit">'.PHP_EOL;
            echo '<input class="button_red" type="submit" value="Löschen" name="delete" onclick="return fConfirm()">'.PHP_EOL;
            echo '<input type="hidden" name="item" value="'.$ev->event['id'].'">'.PHP_EOL;
            echo '</form>';
        }
    }
    echo '<hr>'.PHP_EOL;
}
?>

<form name="n" id="n" action="<?php echo CONTROLLER; ?>" method="post">
    <input type="submit" class="button" name="add" value="Hinzufügen">
    <input type="hidden" name="site" value="collect_event">
</form>
</div>

