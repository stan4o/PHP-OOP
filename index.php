<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$user = new User();

if ($user->isLoggedIn()) {
    include 'includes/user/menu.php';
} else {
    include 'includes/content/login-form.php';
}