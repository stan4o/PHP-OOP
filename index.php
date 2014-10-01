<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$view->addView('menus/main-menu');

if ($user->isLoggedIn()) {
    $view->addView('menus/user-menu');
} else {
    $view->addView('content/login-form');
}

$view->title = "Home";
echo $view->render();