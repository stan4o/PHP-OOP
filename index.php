<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$user = new User();

include 'includes/content/main-menu.php';

if ($user->isLoggedIn()) {
    include 'includes/user/menu.php';
} else {
    include 'includes/content/login-form.php';
}