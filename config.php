<?php

define('DEBUG', true);

# Root/Folders of CMS

# server production
# define('ROOT', 'https://repo.kodinerds.net/eventserver/');

# server testing
define('ROOT', 'https://event.bj4mw.duckdns.org/');

# Kodinerds User URL/Cookies

define('KN_USER', 'https://www.kodinerds.net/index.php/User/');
define('KN_LOGIN', 'https://www.kodinerds.net/index.php/Login/');
define('COOKIE_PATH', $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');

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
define('NAVIGATION', 'navi.php');       # Navigation


# global MVC-Context

define('CONTEXT', true);
?>
