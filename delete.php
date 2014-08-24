<?php

require 'core/init.php';

$user = new User();

if (!$user->isLoggedIn() || !$user->hasPermission('admin')) Redirect::to('index.php');

if (Session::exists('delete')) {
    echo "<p>" . Session::flash('delete') . "</p>";
}

$action = (Input::get('action')) ? Input::get('action') : NULL;
$id = (Input::get('id')) ? (int) Input::get('id') : NULL;

if ($action === 'users' && !is_null($id)) {

    $loggedUser = (int) Session::get(Config::get('session/session_name'));

    if ($user->find($id) && !($id === $loggedUser)) {

        $user->delete($id);

        Session::flash('home', 'You have deleted the user successfully');
        Redirect::to('index.php');

    } else {

        Session::flash('home', 'You can\'t delete yourself');
        Redirect::to('index.php');

    }

} else if ($action === 'posts') {

    echo 'posts';

} else {

    Redirect::to(404);

}