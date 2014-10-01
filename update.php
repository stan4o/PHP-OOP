<?php

require_once 'core/init.php';

if (!$user->isLoggedIn()) Redirect::to('index.php');

if (Session::exists('update')) {
    echo "<p>" . Session::flash('update') . "</p>";
}

$action = (Input::get('action')) ? Input::get('action') : NULL;

if ($action === 'details') {
    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'required' => TRUE,
                    'min' => 2,
                    'max' => 50
                )
            ));

            if ($validation->passed()) {
                try {
                    $user->update(array(
                        'name' => Input::get('name')
                    ));

                    Session::flash('home', "Your details have been updated!");
                    Redirect::to('index.php');

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                Session::flash('update', implode("<br>", $validation->errors()));
                Redirect::to('update.php', array('action' => 'details'));
            }
        }
    }

$view->addView('content/update-details-form');

} else if ($action === 'users' && $user->hasPermission('admin')) {
     if (!$user->find()) {
        Session::flash('create', 'No users found. Create new one!');
        Redirect::to('create.php', array('action' => 'users'));
    }

    $view->data = $user->data();

    $view->addView('content/update-users');

} else if ($action === 'posts' && $user->hasPermission('admin')) {
    $post = new Post();

    if (!$post->find()) {
        Session::flash('create', 'No blog posts created. Create one!');
        Redirect::to('create.php', array('action' => 'posts'));
    }

    $view->data = $post->data();

    if (!$postId = Input::get('id')) {
        $view->addView('content/update-posts');
    } else {
        if (!$post->find($postId)) Redirect::to('index.php');
        $view->data = $post->data();

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
                        $post->update(
                            array(
                                'title' => escape(Input::get('title')),
                                'body' => escape(Input::get('body')),
                                'created' => date("Y-m-d H:i:s")
                            ),
                            $data->id
                        );

                        Session::flash('update', 'The post has been updated!');
                        Redirect::to('update.php', array('action' => 'posts'));

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    Session::flash('update', implode("<br>", $validation->errors()));
                    Redirect::to("update.php", array('action' => 'posts', 'id' => $data->id));
                }
            }
        }

        $view->addView('content/update-posts-form');
    }

} else {
    Redirect::to(404);
}

$view->title = "Update {$action}";
echo $view->render();