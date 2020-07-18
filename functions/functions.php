<?php
function scanFolder($folder, $exceptions)
{
    if (is_dir($folder) and is_array(scandir($folder))) {
        return array_values(array_filter(array_diff(scandir($folder), $exceptions)));
    }
    return false;
}
