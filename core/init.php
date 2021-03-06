<?php

// Start the session
session_start();

// Define internel encoding
mb_internal_encoding('UTF-8');

// Define BASE URI and DIRECTORY_SEPARATOR
if (!defined("DS")) define("DS", DIRECTORY_SEPARATOR);
if (!defined("BASE")) define("BASE", dirname(dirname(__FILE__)) . DS);
if (!defined("TMP")) define("TMP", BASE . "includes" . DS);

// Configurations array
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'test',
        'password' => 'test',
        'db' => 'test'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

// Load all requested classes
spl_autoload_register(function ($class) {
    require_once 'classes/' . $class . '.php';
});

// Require sanitizing functions
require_once 'functions/sanitize.php';

// User instance
$user = new User();

// View
$view = new View();

// Asign the user object
$view->user = $user;

// Load external resources
$view->addHeadInfo('stylesheet', '../includes/css/main.css');
$view->addHeadInfo('script', '//code.jquery.com/jquery-1.11.0.min.js');
$view->addHeadInfo('script', '../includes/js/main.js');

// Auto login for 'remember me' functionality
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_sessions', array('hash', '=', $hash));

    if ($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}

// Include the main menu
include TMP . 'menus/main-menu.tpl.php';