<?php
function scanFolder($folder, $exceptions)
{
    if (is_dir($folder) and is_array(scandir($folder))) {
        return array_values(array_filter(array_diff(scandir($folder), $exceptions)));
    }
    return false;
}

function gerTF($datetime, $f_out, $f_in='Y-m-d H:i') {
    return DateTime::createFromFormat($f_in, $datetime)->format($f_out);
}

function shorten($p, $maxlenght=100) {
    if (strlen($p) > $maxlenght -3) return substr($p,0,$maxlenght-3).'...';
    return $p;
}

function extlink($link) {
    return '<a href="'.$link.'"><img src="'.EXTLINK.'" class="extlink"></a>';
}

# compare functions fpr usort

function compare_date($p1, $p2) {
    return strcmp($p1->event_date, $p2->event_date);
}

function compare_eventdate($p1, $p2) {
    return strcmp($p1['event_date'], $p2['event_date']);
}
