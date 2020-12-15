<?php

define('DEBUG', false);

# Root/Folders of CMS

# server production
define('ROOT', 'https://events.kodinerds.net/');

# server testing
# define('ROOT', 'https://event.bj4mw.duckdns.org/');

# Kodinerds User URL/Cookies/Links

define('KN_USER', 'https://www.kodinerds.net/index.php/User/');
define('KN_LOGIN', 'https://www.kodinerds.net/index.php/Login/');
define('COOKIE_PATH', $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');

define('KN_VES_ANNOUNCEMENT', 'https://www.kodinerds.net/index.php/Thread/70207-RELEASE-KN-Video-Event-Service-und-Video-Event-Server/');
# --------------------------------------------------------- #

define('CONTROLLER', 'index.php');
define('VIEWS', 'views/');

# Stylesheets

define('CSS', 'css/styles.css');
define('DATA', 'database/');
define('MEDIA', 'database/media/');
define('API', 'api.php');

# Views

define ('DEFAULTPAGE', 'list.php');         # Bootstrap
define ('ERRORPAGE', 'error.php');          # Fehlerseite

define ('LISTVIEW', 'list.php');            # Eventliste
define ('COLLECT', 'collect.php');          # Erfassung
define ('EDIT', 'edit.php');                # Bearbeitung
define ('LOGIN', 'login.php');              # Login


define ('TITLE', 'Kodinerds Event Server: ');
# Model

define('CLASSES', 'classes/');

# Functions

define('FUNCTIONS', 'functions/');

# Helpers, Graphics
define('EXTLINK', 'css/extlink.svg');   # Grafik externer Link
define('COPYLINK', 'css/copy.svg');     # Grafik kopieren
define('EDITLINK', 'css/stift.svg');    # Grafik bearbeiten

define('HEADER', 'header.php');         # Header
define('FOOTER', 'footer.php');         # Footer

# Maintenance

define ('RETENTION_TIME_TEMP', 86400);      # 24 Hours
define ('RETENTION_TIME_PERMA', 2592000);   # 30 Days

# global MVC-Context

define('CONTEXT', true);

