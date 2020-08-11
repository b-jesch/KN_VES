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

} elseif (isset($_GET['maintenance'])) {
    $files = scanFolder(DATA, ['media', '.', '..']);
    foreach ($files as $file) {
        $ev = new Event();
        $ev->read($file);
        if (isset($ev->event['retention_time']) and $ev->event['retention_time'] < time()) {
            # echo $file.' should be deleted';
            unlink(DATA.$file);
        }
    }



} else {
    header('HTTP/1.0 403 Forbidden', true, 403);
    exit;
}



