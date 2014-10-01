<?php

require_once 'core/init.php';

$user->logout();

Session::flash('home', "You have been logged out!");
Redirect::to('index.php');