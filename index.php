<?php
require ('config.php');
require (CLASSES.'event.php');
require (FUNCTIONS.'functions.php');

$c_pars = array_merge($_POST, $_GET, $_FILES);

session_start();

dump($c_pars);

/** read cookie **/

if (isset($_COOKIE['ID'])) {
    $_SESSION['id'] = decryptCookie(KEY, $_COOKIE['ID']);
    $_SESSION['user'] = decryptCookie(KEY, $_COOKIE['Token']);
}

if (!is_numeric($_SESSION['id'])) $c_pars['site'] = 'logout'; //test is ID numeric

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
        
        /** Get DeviceID for 2FA **/
        if (preg_match('/<(.*?)id="device"(.*?)value=(.*?)>/', $site, $match, PREG_OFFSET_CAPTURE) != 1) {
            $c_pars['site'] = 'login';
        } else {
            $device = str_replace('"', '', $match[3][0]);
            curl_setopt($curlHandler, CURLOPT_URL, KN_TWOFACTOR);
            curl_setopt($curlHandler, CURLOPT_POSTFIELDS, '&url=https://www.kodinerds.net/&t=' . $securityToken . '&onetimecode='. $_POST['twofactor']);
            $site = curl_exec($curlHandler);
        }

        /** Get UserID and Username **/
        
        if (preg_match('/<(.*?)href="' . str_replace('/', '\/', KN_USER) . '(.*?)">(.*?)<\/a>/', $site, $response) != 1) {
            $c_pars['site'] = 'login';
        } else {
            $user = str_replace('/', '', $response);
            $_SESSION['id'] = explode('-', $user[2])[0];
            $_SESSION['user'] = $user[3];
            
        /** Set Cookie for remember Login **/

            if (isset($_POST['remember'])) {
                $arr_cookie_options = array (
                    'expires' => time() + 60*60*24*30, 
                    'path' => '/', 
                    'domain' => $_SERVER['HTTP_HOST'], // leading dot for compatibility or use subdomain
                    'secure' => true,     // or false
                    'httponly' => true,    // or false
                    'samesite' => 'None' // None || Lax  || Strict
                    );
                setcookie("Token", encryptCookie(KEY, $_SESSION['user']), $arr_cookie_options);
                setcookie("ID", encryptCookie(KEY, $_SESSION['id']), $arr_cookie_options);
            }
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
        
    case 'logout':
        $arr_cookie_options = array (
            'expires' => time() -3100, 
            'path' => '/', 
            'domain' => $_SERVER['HTTP_HOST'], // leading dot for compatibility or use subdomain
            'secure' => true,     // or false
            'httponly' => true,    // or false
            'samesite' => 'None' // None || Lax  || Strict
            );
        setcookie("ID", "", $arr_cookie_options);
        setcookie("Token", "", $arr_cookie_options);
        unset($_COOKIE['ID']);
        unset($_COOKIE['Token']);
        unset($_SESSION['user']);
        unset($_SESSION['id']);
        session_destroy();        
        $view = VIEWS.LOGIN;
        break;
        
    default:
    # Bootstrap
    $view = VIEWS.DEFAULTPAGE;        
}    
   
require VIEWS.HEADER;
require $view;
require VIEWS.FOOTER;
