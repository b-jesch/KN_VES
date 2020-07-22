<?php
require ('config.php');
require (CLASSES.'event.php');
require (FUNCTIONS.'functions.php');

$c_pars = array_merge($_POST, $_GET, $_FILES);
session_start();

if (isset($c_pars['check'])) {
    if (!empty($c_pars['username']) and !empty($c_pars['password'])) {
        $c_pars['site'] = 'list_event';

        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, KN_LOGIN);
        curl_setopt($curlHandler, CURLOPT_POST, 1);
        curl_setopt($curlHandler, CURLOPT_COOKIEJAR, COOKIE_PATH);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);

        /** Get security token */
        if (preg_match('/(.*?)SECURITY_TOKEN = \'(.*?)\';/', curl_exec($curlHandler), $match) != 1) {
            $c_pars['site'] = 'login';
        }
        $securityToken = $match[2];

        /** Log in */
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, 'username='.urlencode($_POST['username']).'&password='.urlencode($_POST['password']).'&useCookies=1&action=login&t='.$securityToken);
        $site = curl_exec($curlHandler);
        # if (preg_match('/(.*?)<a href="https:\/\/www\.kodinerds\.net\/index\.php\/User\/(.*?)\/" class="framed">/', $site, $user) != 1) {
        if (preg_match('/(.*?)<a href="'.str_replace('/', '\/', KN_USER).'(.*?)\/" class="framed">/', $site, $user) != 1) {
                $c_pars['site'] = 'login';
        } else {
            $_SESSION['id'] = explode('-', $user[2])[0];
            $_SESSION['user'] = explode('-', $user[2])[1];
        }
    } else {
        $c_pars['site'] = 'login';
    }
} elseif (isset($c_pars['abort'])) {
    if (isset($_SESSION['user'], $_SESSION['id'])) {
        $c_pars['site'] = 'list_event';
    } else {
        $c_pars['site'] = 'login';
    }
} elseif (isset($_SESSION['user'], $_SESSION['id'], $c_pars['site']) && $c_pars['site'] == 'collect_event') {
    //
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
        $view = VIEWS.LISTVIEW;
        break;
    case 'collect_event':
        $title = TITLE.'Eventdaten erfassen';
        $view = VIEWS.COLLECT;
        break;

    case 'collect_2':
        $ev = new Event();
        $ev->create($c_pars, $_SESSION['user'], $_SESSION['id']);
        $ev->persist();
        $title = TITLE.'Events auflisten';
        $view = VIEWS.LISTVIEW;
        break;

    case 'edit':
        $title = TITLE.'Event bearbeiten';
        $view = VIEWS.EDIT;
        break;

    case 'delete':
        if (is_file(DATA.$c_pars['item'])) {
            unlink(DATA.$c_pars['item']);
            $title = TITLE.'Events auflisten';
            $view = VIEWS.LISTVIEW;
        }
        break;
        
    default:
        # Bootstrap
        $title = TITLE.'Check In';
        $view = VIEWS.DEFAULTPAGE;
}

require VIEWS.HEADER;
require $view;
require VIEWS.FOOTER;
