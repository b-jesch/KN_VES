<?php

# Prolog

if (!defined('CONTEXT')) {
    require '../config.php';
    header('Location: ' . ROOT);
    exit();
}

echo '<div class="content" type="large">';
echo '<h1>'.TITLE.'Events auflisten und eintragen</h1>';

?>

<div class="add_area">
    <form name="n" id="n" action="<?php echo CONTROLLER; ?>" method="post">
        <input type="submit" class="button" name="add" title="neuen Eintrag auf dem Server erstellen" value="Hinzufügen">
        <input type="hidden" name="site" value="collect">
    </form>
</div>

<?php
$events = scanFolder(DATA, ['media', '..', '.']);
if ($events) {
    foreach ($events as $event) {
        $ev = new Event();
        $ev->read($event);
        $event_list[] = $ev->event;
    }
    usort($event_list, 'compare_eventdate');

    foreach ($event_list as $ev) {
        echo '<div class="content_area"><h2>';
        echo gerTF($ev['event_date'], 'd.m.Y', 'Y-m-d');

        echo '</h2>'.PHP_EOL;
        echo '<h3>'.$ev['event'].' ['.$ev['genre'].']';
        copylink($ev['id']);
        echo '</h3>'.PHP_EOL;
        echo '<p>'.nl2br($ev['plot']).'</p>'.PHP_EOL;
        if (!empty($ev['web'])) {
            echo '<a href="'.$ev['web'].'" target="_blank" rel="noopener">'.shorten($ev['web']).'</a>'.PHP_EOL;
        }
        echo '<hr>'.PHP_EOL;
        echo 'Stream: ';
        echo empty($ev['stream']) ? 'k.A. <img src="'.EDITLINK.'" class="extlink" nofloat title="Stream muss nachgetragen werden">'.PHP_EOL : shorten($ev['stream']).extlink($ev['stream']).PHP_EOL;
        if ($ev['permalink']) {
            echo '<br>Permalink'.PHP_EOL;
        } else {
            echo '<br>gültig ab: ';
            echo empty($ev['from']) ? 'k.A'.PHP_EOL : gerTF($ev['from'], 'd.m.y H:i').PHP_EOL;
            echo ' bis ';
            echo empty($ev['to']) ? 'k.A'.PHP_EOL : gerTF($ev['to'], 'd.m.y H:i').PHP_EOL;
        }
        echo '<hr>'.PHP_EOL;
        echo 'Icon: ';
        echo empty($ev['icon']) ? 'k.A'.PHP_EOL : '<a href="'.$ev['icon']. '" target="_blank" rel="noopener">' .shorten($ev['icon']).'</a>'.PHP_EOL;
        echo '<br>Poster: ';
        echo empty($ev['fanart']) ? 'k.A'.PHP_EOL : '<a href="'.$ev['fanart']. '" target="_blank" rel="noopener">' .shorten($ev['fanart']).'</a>'.PHP_EOL;
        echo '<p class="small">erstellt von '.$ev['user'].' ['. implode(', ', $ev['user_id']) .'], wird entfernt am '.gerTFfromTimestamp($ev['retention_time']).'</p></div>'.PHP_EOL;
        echo '<form name="'.$ev['id'].'" id="'.$ev['id'].'" action="'.CONTROLLER.'" method="POST">';
        echo '<input type="hidden" name="item" value="'.$ev['id'].'">'.PHP_EOL;
        if ($ev['iseditable'] or (empty($ev['stream']) and !$ev['permalink'])) {
            echo '<input type="hidden" name="stream_'.$ev['id'].'" id="stream_'.$ev['id'].'" value="">'.PHP_EOL;
            echo '<input type="hidden" name="insert" id="insert" value="insert">'.PHP_EOL;
            echo '<input class="button" type="button" value="Stream eintragen" 
                  title="Stream-Link nachtragen oder ändern" name="edit_stream" onclick="fPrompt('.$ev['id'].')">'.PHP_EOL;
        }
        if (in_array($_SESSION['id'], $ev['user_id'])) {
            echo '<input class="button" type="submit" value="Bearbeiten" title="Eintrag bearbeiten" name="edit">'.PHP_EOL;
            echo '<input class="button_red" type="submit" value="Löschen" title="Eintrag löschen" name="delete" onclick="return fConfirm()">'.PHP_EOL;
        }
        echo '</form>';
    }
    echo '<hr>'.PHP_EOL;
    echo '<div class="add_area">'.PHP_EOL;
    echo '<input type="submit" form="n" class="button" name="add" title="neuen Eintrag auf dem Server erstellen" value="Hinzufügen">'.PHP_EOL;
    echo '</div>'.PHP_EOL;
}
echo '</div>'.PHP_EOL;

