<?php

require 'core/init.php';

$user = new User();

if (!$user->isLoggedIn() || !$user->hasPermission('admin')) Redirect::to('index.php');

if (Session::exists('create')) {
    echo "<p>" . Session::flash('create') . "</p>";
}