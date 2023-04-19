<?php
require ('config.php');
require (CLASSES.'event.php');
require (FUNCTIONS.'functions.php');

$c_pars = array_merge($_POST, $_GET, $_FILES);
session_start();

dump($c_pars);

if (!isset($_SESSION['id'])) $c_pars['site'] = 'login';

if (isset($c_pars['check'])) {
    if (empty($c_pars['username']) or empty($c_pars['password'])) {
        $c_pars['site'] = 'login';
    } else {
        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, KN_LOGIN);
        curl_setopt($curlHandler, CURLOPT_POST, 1);
        curl_setopt($curlHandler, CURLOPT_COOKIEJAR, COOKIE_PATH);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandler, CURLOPT_HEADER, 1);
        curl_setopt($curlHandler, CURLOPT_FOLLOWLOCATION, 1);

        /** Get security token */
        if (preg_match('/(.*?)XSRF-TOKEN=(.*?);/', curl_exec($curlHandler), $match, PREG_OFFSET_CAPTURE) != 1) {
            $c_pars['site'] = 'login';
        }
        $securityToken = $match[2][0];

        /** Log in */
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, 'username=' . urlencode($_POST['username']) . '&password=' . urlencode($_POST['password']) . '&url=https://www.kodinerds.net/&t=' . $securityToken);
        $site = curl_exec($curlHandler);

        # if (preg_match('/(.*?)<a href="https:\/\/www\.kodinerds\.net\/index\.php\/User\/(.*?)\/" class="framed">/', $site, $user) != 1) {
        if (preg_match('/(.*?)href="' . str_replace('/', '\/', KN_USER) . '(.*?)"/', $site, $response) != 1) {
            $c_pars['site'] = 'login';
        } else {
            $user = str_replace('/', '', $response);
            $_SESSION['id'] = explode('-', $user[2])[0];
            $_SESSION['user'] = explode('-', $user[2],2)[1];
            $c_pars['site'] = 'list_event';
        }
    }
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
elseif (isset($c_pars['item'], $c_pars['insert'])) {
    $urlvalue = 'stream_'.$c_pars['item'];
    if (empty($c_pars[$urlvalue])) $c_pars['site'] = 'list_event';
    else $c_pars['site'] = 'collect_3';
}

switch ($c_pars['site']) {
    case 'list_event':
        $view = VIEWS.LISTVIEW;
        break;

    case 'collect':
        $view = VIEWS.COLLECT;
        break;

    case 'collect_2':
        $ev = new Event();
        if ($ev->read($c_pars['item'])) {
            $ev->create($c_pars, $ev->event['user'], $ev->event['user_id'][0]);
        } else {
            $ev->create($c_pars, $_SESSION['user'], $_SESSION['id']);
        }

        if ($c_pars['icon_upload']['error'] == UPLOAD_ERR_OK) $ev->event['icon'] = handleUpload('icon', $c_pars['item'], $c_pars['icon_upload']);
        if ($c_pars['fanart_upload']['error'] == UPLOAD_ERR_OK) $ev->event['fanart'] = handleUpload('fanart', $c_pars['item'], $c_pars['fanart_upload']);

        $ev->persist();
        $view = VIEWS.LISTVIEW;
        break;

    case 'collect_3':
        $ev = new Event();
        $ev->read($c_pars['item']);
        $ev->event['stream'] = $c_pars[$urlvalue];

        if (!in_array($_SESSION['id'], $ev->event['user_id'])) $ev->event['user_id'][] = $_SESSION['id'];

        $ev->persist();
        $view = VIEWS.LISTVIEW;
        break;

    case 'edit':
        $view = VIEWS.EDIT;
        break;

    case 'delete':
        $ev = new Event();
        if ($ev->read($c_pars['item'])) {
            if (is_file(MEDIA.basename($ev->event['icon']))) unlink(MEDIA.basename($ev->event['icon']));
            if (is_file(MEDIA.basename($ev->event['fanart']))) unlink(MEDIA.basename($ev->event['fanart']));
            unlink(DATA.$c_pars['item']);
        }
        $view = VIEWS.LISTVIEW;
        break;

    case 'login':
        $view = VIEWS.LOGIN;
        break;

    default:
        # Bootstrap
        $view = VIEWS.DEFAULTPAGE;
}

require VIEWS.HEADER;
require $view;
require VIEWS.FOOTER;
