<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$user = new User();

include TMP . 'menus/main-menu.tpl.php';


if ($user->isLoggedIn()) {
    include TMP . 'menus/user-menu.tpl.php';
} else {
    include TMP . 'content/login-form.tpl.php';
}