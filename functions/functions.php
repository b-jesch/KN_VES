<?php
function scanFolder($folder, $exceptions)
{
    if (is_dir($folder) and is_array(scandir($folder))) {
        return array_values(array_filter(array_diff(scandir($folder), $exceptions)));
    }
    return false;
}

function gerTF($datetime, $f_out, $f_in='Y-m-d H:i') {
    $dt = DateTime::createFromFormat($f_in, $datetime)->format($f_out);
    if ($dt) return $dt;
    return $datetime;
}

function gerTFfromTimestamp($timestamp, $f_out='d.m.Y') {
    if ($timestamp > 0) {
        return DateTime::createFromFormat('U', $timestamp)->format($f_out);
    }
}

function shorten($p, $maxlenght=90) {
    if (strlen($p) > $maxlenght -3) return substr($p,0,$maxlenght-3).'...';
    return $p;
}

function extlink($link) {
    return '<a href="'.$link.'" target="_blank" rel="noopener"><img src="'.EXTLINK.'" class="extlink"  alt="Link zum Stream" title="Link zum Stream"></a>';
}

function copylink($link) {
    echo "<a href='#' onclick=\"winBBCopen('".API."?get_event&id=$link"."', 'BBCode Window', 800, 400);\">".PHP_EOL;
    echo "<img class='extlink' src='".COPYLINK."' title='Inhalt des Events in BBCode zum Kopieren anzeigen'></a>";
}

# compare functions fpr usort

function compare_date($p1, $p2) {
    return strcmp($p1->event_date, $p2->event_date);
}

function compare_eventdate($p1, $p2) {
    return strcmp($p1['event_date'], $p2['event_date']);
}

# upload

function handleUpload($type, $prefix, $upload) {
    switch ($upload['type']) {
        case 'image/gif':
            $ext = '.gif';
            break;
        case 'image/png':
            $ext = '.png';
            break;
        case 'image/jpeg':
            $ext = '.jpg';
            break;
        case 'image/svg+xml':
            $ext = '.svg';
            break;
        case 'image/wbmp':
            $ext = '.wbmp';
            break;
        default:
            $ext = '';
    }
    if (move_uploaded_file($upload['tmp_name'], MEDIA.$prefix.'-'.$type.$ext)) {
        return ROOT.MEDIA.$prefix.'-'.$type.$ext;
    }
    return '';
}

# helper

function dump($object) {
    if (DEBUG) {
        echo '<pre>'.PHP_EOL;
        var_dump($object);
        echo '</pre>'.PHP_EOL;
    }
}