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
        $response = ['result' => 'ok', 'code' => '30031', 'item' => $playlist];
    }

    header('Content-type: application/json');
    echo json_encode($response);

} else {
    header('HTTP/1.0 403 Forbidden', true, 403);
    exit;
}



