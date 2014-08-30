<?php

class Redirect {

    public static function to($location = NULL, $params = array()) {
        if ($location) {

            if (is_numeric($location)) {
                switch ($location) {
                    case '404':
                        header('HTTP/1.0 404 Not found');
                        include 'includes/errors/404.php';
                        exit();
                        break;
                }
            }

            if ($params) {
                $location .= "?";
                $pos = 1;
                $keys = count($params);

                foreach ($params as $k => $v) {
                    $location .= $k . "=" . $v;
                    if ($pos < $keys) {
                        $location .= "&";
                    }
                }
            }

            header('Location: ' . $location);
            exit();
        }
    }

}