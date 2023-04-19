<?php

const DEBUG = false;

# Root/Folders of CMS

# server production
const ROOT = 'https://events.kodinerds.net/';

# server testing
# define('ROOT', 'https://event.bj4mw.duckdns.org/');

# Kodinerds User URL/Cookies/Links

define('KN_USER', 'https://beta.kodinerds.net/wcf/user/');
define('KN_LOGIN', 'https://beta.kodinerds.net/wcf/login/');
define('COOKIE_PATH', $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');

const KN_VES_ANNOUNCEMENT = 'https://www.kodinerds.net/index.php/Thread/70207-RELEASE-KN-Video-Event-Service-und-Video-Event-Server/';
# --------------------------------------------------------- #

const CONTROLLER = 'index.php';
const VIEWS = 'views/';

# Stylesheets

const CSS = 'css/styles.css';
const DATA = 'database/';
const MEDIA = 'database/media/';
const API = 'api.php';

# Views

const DEFAULTPAGE = 'list.php';         # Bootstrap
const ERRORPAGE = 'error.php';          # Fehlerseite

const LISTVIEW = 'list.php';            # Eventliste
const COLLECT = 'collect.php';          # Erfassung
const EDIT = 'edit.php';                # Bearbeitung
const LOGIN = 'login.php';              # Login


const TITLE = 'Kodinerds Event Server: ';
# Model

const CLASSES = 'classes/';

# Functions

const FUNCTIONS = 'functions/';

# Helpers, Graphics
const EXTLINK = 'css/extlink.svg';   # Grafik externer Link
const COPYLINK = 'css/copy.svg';     # Grafik kopieren
const EDITLINK = 'css/stift.svg';    # Grafik bearbeiten

const HEADER = 'header.php';         # Header
const FOOTER = 'footer.php';         # Footer

# Maintenance

const RETENTION_TIME_TEMP = 86400;      # 24 Hours
const RETENTION_TIME_PERMA = 2592000;   # 30 Days

# global MVC-Context

const CONTEXT = true;

