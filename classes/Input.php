<?php

class Input {

    public static function exists($type = 'post') {

        switch($type) {
            case 'post':
                return ($_POST) ? TRUE : FALSE;
            break;

            case 'get':
                return ($_GET) ? TRUE : FALSE;
            break;

            default:
                return FALSE;
            break;
        }

    }

    public static function get($item = NULL) {

        if (isset($_POST[$item])) {
            return $_POST[$item];
        } elseif (isset($_GET[$item])) {
            return $_GET[$item];
        }

        return "";
    }

}