<?php

require_once 'core/init.php';

if (Session::exists('register')) {
    echo "<p>" . Session::flash('register') . "</p>";
}

$view->addView('content/create-users');
$view->title = "Register";
echo $view->render();