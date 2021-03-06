<?php

require 'core/init.php';

if (Session::exists('create')) {

    echo "<p>" . Session::flash('create') . "</p>";

}

$action = (Input::get('action')) ? Input::get('action') : NULL ;

if ($action === 'users') {

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {

            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'
                ),
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                )
            ));

            if ($validation->passed()) {

                $salt = Hash::salt(32);

                try {

                    $user->create(array(
                        'username' => Input::get('username'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                        'name' => Input::get('name'),
                        'joined' => date("Y-m-d H:i:s"),
                        'group' => 1
                    ));

                    Session::flash('home', 'You have been successfully registered!');
                    Redirect::to('index.php');

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                Session::flash('register', implode("<br>", $validation->errors()));
                Redirect::to('register.php');
            }
        }
    }

$view->addView('content/create-users');

} else if ($action === 'posts') {

if (!$user->isLoggedIn() || !$user->hasPermission('admin')) Redirect::to('index.php');

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {

            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'title' => array(
                    'required' => TRUE,
                    'min' => 2,
                    'max' => 150
                ),
                'body' => array(
                    'required' => TRUE,
                    'min' => 2,
                    'max' => 10000
                )
            ));

            if ($validation->passed()) {
                try {

                    $post = new Post();
                    $post->create(array(
                        'title' => Input::get('title'),
                        'body' => Input::get('body'),
                        'created' => date("Y-m-d H:i:s")
                    ));

                    Session::flash('home', 'Post created successfully!');
                    Redirect::to('index.php');

                } catch (Exception $e) {
                    $e->getMessage();
                }
            } else {
                Session::flash('create', implode("<br>", $validation->errors()));
                Redirect::to('create.php', array('action' => 'posts'));
            }

        }
    }

    $view->addView('content/create-posts');

} else {

    Redirect::to(404);

}

$view->title = "Create {$action}";
echo $view->render();