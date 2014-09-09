<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$user = new User();

if ($user->isLoggedIn()) {
    include TMP . 'user/menu.php';
} else {
    include TMP . 'content/login-form.php';
}