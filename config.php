<?php

define('DEBUG', true);

# --------------------------------------------------------- #

define('CONTROLLER', 'index.php');
define('VIEWS', 'views/');

# Stylesheets

define('CSS', 'css/styles.css');
define('DATA', 'database/');
define('MEDIA', 'database/media/');
define('API', 'api/api.php');

# Views

define ('DEFAULTPAGE', 'login.php');        # Bootstrap
define ('ERRORPAGE', 'error.php');          # Fehlerseite

define ('LISTVIEW', 'list.php');            # Eventliste
define ('COLLECT', 'collect.php');          # Erfassung
define ('EDIT', 'edit.php');                # Bearbeitung

define ('TITLE', 'Kodinerds Event Server: ');
# Model

define('CLASSES', 'classes/');

# Functions

define('FUNCTIONS', 'functions/');

# Helpers

define('HEADER', 'header.php');         # Header
define('FOOTER', 'footer.php');         # Footer


# global MVC-Context

define('CONTEXT', true);
