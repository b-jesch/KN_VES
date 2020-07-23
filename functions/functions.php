<?php
function scanFolder($folder, $exceptions)
{
    if (is_dir($folder) and is_array(scandir($folder))) {
        return array_values(array_filter(array_diff(scandir($folder), $exceptions)));
    }
    return false;
}

# compare functions fpr usort

function compare_date($p1, $p2) {
    return strcmp($p1->ts_from, $p2->ts_from);
}
