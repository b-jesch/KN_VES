<?php
# Prolog
if (!defined('CONTEXT')) {
    require 'start.php';
    header('Location: '.ROOT);
    exit();
}
include HEADER;

# Inhalt der View


?>

Hallo Welt

<?php
# Epilog
include FOOTER;