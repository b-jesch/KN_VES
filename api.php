<?php
require ('config.php');
require (CLASSES.'event.php');
require (FUNCTIONS.'functions.php');

if (isset($_GET['playlist'])) {
    $playlist = array();
    $files = scanFolder(DATA, ['media', '.', '..']);
    foreach ($files as $file) {
        $ev = new Event();
        $ev->read_raw($file);
        $playlist[] = json_decode($ev->raw_data);
    }
    if (empty($playlist)) {
        $response = ['result' => 'ok', 'code' => '30030', 'item' => $playlist];
    } else {
        usort($playlist, 'compare_date');
        $response = ['result' => 'ok', 'code' => '30031', 'item' => $playlist];
    }

    header('Content-type: application/json');
    echo json_encode($response);

} elseif (isset($_GET['maintenance']) or $argv[1] == 'maintenance') {
    $files = scanFolder(DATA, ['media', '.', '..']);
    $count = 0;
    foreach ($files as $file) {
        $ev = new Event();
        $ev->read($file);
        if (isset($ev->event['retention_time']) and $ev->event['retention_time'] < time()) {
            unlink(DATA . $file);
            $count++;
        }
    }
    echo "$count event(s) removed".PHP_EOL;

} elseif (isset($_GET['get_event'], $_GET['id']) and !empty($_GET['id'])) {
    $ev = new Event();
    if ($ev->read($_GET['id'])) {
        echo '<meta charset="UTF-8">';
        echo '<pre>';
        echo '[size=12][b]'.gerTF($ev->event['event_date'], 'd.m.Y', 'Y-m-d').'[/b][/size]'.PHP_EOL;
        echo '[size=14]'.$ev->event['event'].' ['.$ev->event['genre'].'][/size]'.PHP_EOL.PHP_EOL;
        echo $ev->event['plot'].PHP_EOL.PHP_EOL;
        if (!empty($ev->event['web'])) {
            echo 'WebURL: [url='.$ev->event['web'].']'.shorten($ev->event['web']).'[/url]'.PHP_EOL.PHP_EOL;
        }
        echo 'Stream: ';
        echo empty($ev->event['stream']) ? 'k.A. [color=red]&#9998;[/color]'.PHP_EOL : '[url='.$ev->event['stream'].']'.shorten($ev->event['stream']).'[/url]'.PHP_EOL.PHP_EOL;
        if ($ev->event['permalink']) {
            echo 'Permalink'.PHP_EOL;
        } else {
            echo 'gültig ab: ';
            echo empty($ev->event['from']) ? 'k.A'.PHP_EOL : gerTF($ev->event['from'], 'd.m.y H:i');
            echo ' bis ';
            echo empty($ev->event['to']) ? 'k.A'.PHP_EOL : gerTF($ev->event['to'], 'd.m.y H:i').PHP_EOL;
        }
        echo PHP_EOL.PHP_EOL;
        echo 'Verfügbar auf dem [url='.ROOT.']Kodinerds Event Server[/url] ';
        echo 'und im [url='.KN_VES_ANNOUNCEMENT.']Kodinerds Event Service[/url] Addon.'.PHP_EOL;
        echo '</pre>';

    } else {
        header('HTTP/1.0 404 Not found', true, 404);
        exit();
    }

} else {
    header('HTTP/1.0 403 Forbidden', true, 403);
    exit();
}



