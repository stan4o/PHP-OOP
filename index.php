<?php

require_once 'core/init.php';

if (Session::exists('home')) {
    echo "<p>" . Session::flash('home') . "</p>";
}

$view->addView('menus/main-menu');

if ($user->isLoggedIn()) {
<<<<<<< .mine
    include TMP . 'menus/user-menu.tpl.php';
=======
    $view->addView('menus/user-menu');
>>>>>>> .r72
} else {
<<<<<<< .mine
    include TMP . 'content/login-form.tpl.php';
}=======
    $view->addView('content/login-form');
}

$view->title = "Home";
echo $view->render();>>>>>>> .r72
