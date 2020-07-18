<?php
require ('config.php');
require (CLASSES.'event.php');
require (FUNCTIONS.'functions.php');

$c_pars = array_merge($_POST, $_GET, $_FILES);
session_start();

if (isset($c_pars['check'])) {
    if (!empty($c_pars['user']) and !empty($c_pars['id'])) {

        $_SESSION['user'] = $c_pars['user'];
        $_SESSION['id'] = $c_pars['id'];

        $c_pars['site'] = 'list_event';
    } else {
        $c_pars['site'] = 'login';
    }
} elseif (isset($c_pars['abort'])) {
    if (isset($_SESSION['user'], $_SESSION['id'])) {
        $c_pars['site'] = 'list_event';
    } else {
        $c_pars['site'] = 'login';
    }
} elseif (isset($_SESSION['user'], $_SESSION['id'])) {
    # $c_pars['site'] = 'list_event';
} else {
    $c_pars['site'] = 'login';
}

# Main Controller

if (isset($c_pars['item'], $c_pars['edit'])) {
    $c_pars['site'] = 'edit';
}
elseif (isset($c_pars['item'], $c_pars['delete'])) {
    $c_pars['site'] = 'delete';
}
elseif (isset($c_pars['item'], $c_pars['add'])) {
    $c_pars['site'] = 'collect_2';
}

switch ($c_pars['site']) {
    case 'list_event':
        $title = TITLE.'Events auflisten';
        require VIEWS.LISTVIEW;
        break;
    case 'collect_event':
        $title = TITLE.'Eventdaten erfassen';
        require VIEWS.COLLECT;
        break;

    case 'collect_2':
        $ev = new Event();
        $ev->create($c_pars, $_SESSION['user'], $_SESSION['id']);
        $ev->persist();
        require VIEWS.LISTVIEW;
        break;

    case 'edit':
        $title = TITLE.'Event bearbeiten';
        require VIEWS.EDIT;
        break;

    case 'delete':
        if (is_file(DATA.$c_pars['item'])) {
            unlink(DATA.$c_pars['item']);
            require VIEWS.LISTVIEW;
        }
        break;

    case 'login':
        $title = TITLE.'Check In';
        require VIEWS.DEFAULTPAGE;
        break;
    default:
        # Bootstrap
        $title = TITLE.'Check In';
        require VIEWS.DEFAULTPAGE;
}