<?php
function scanFolder($folder, $exceptions)
{
    if (is_dir($folder) and is_array(scandir($folder))) {
        return array_values(array_filter(array_diff(scandir($folder), $exceptions)));
    }
    return false;
}

function gerTF($datetime, $f_out, $f_in='Y-m-d H:i') {
    try {
        return DateTime::createFromFormat($f_in, $datetime)->format($f_out);
    } catch(Exception $e) {
        return $datetime;
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
    echo "<a target='popup' ";
    echo "onclick=\"window.open('', 'popup', 'width=580,height=360,scrollbars=yes,toolbar=no,status=no,resizable=yes,";
    echo "menubar=no,location=no,directories=no,top=30,left=30') ";
    echo "\"href='".API."?get_event&id=$link'>";
    echo "<img class='extlink' src='".COPYLINK."' title='Inhalt des Events in BBCode zum Kopieren anzeigen'></a>";
}

# compare functions fpr usort

function compare_date($p1, $p2) {
    return strcmp($p1->event_date, $p2->event_date);
}

function compare_eventdate($p1, $p2) {
    return strcmp($p1['event_date'], $p2['event_date']);
}

function dump($object) {
    if (DEBUG) {
        echo '<pre>'.var_dump($object).'</pre>';
    }
}