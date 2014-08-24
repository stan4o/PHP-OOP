<?php

require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => TRUE,
                'min' =>2
            ),
            'password' => array(
                'required' => TRUE,
                'min' =>6
            ),
        ));

        if ($validation->passed()) {

            $remember = (Input::get('remember') === "on") ? TRUE : FALSE;
            $user = new User();
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login) {
                Session::flash('home', 'You have been successfuly logged in!');
            } else {
                Session::flash('home', 'Sorry, login atempt failed!');
            }

        } else {
            Session::flash('home', implode("<br>", $validation->errors()));
        }

        Redirect::to('index.php');
    }
}