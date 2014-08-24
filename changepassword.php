<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) Redirect::to('index.php');

if (Session::exists('password')) {
    echo "<p>" . Session::flash('password') . "</p>";
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => TRUE,
            ),
            'password_new' => array(
                'required' => TRUE,
                'min' => 6,
            ),
            'password_new_again' => array(
                'required' => TRUE,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));

        if ($validation->passed()) {

            if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {

                echo "Your current password is worng";

            } else {

                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));

                Session::flash('home', "Your password has been changed!");
                Redirect::to('index.php');

            }

        } else {
            Session::flash('password', implode("<br>", $validation->errors()));
            Redirect::to('changepassword.php');
        }

    }
}

include 'includes/content/changepassword-form.php';