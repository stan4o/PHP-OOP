<?php

class Config {

    public static function get($path = NULL) {

        $config = false;

        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $bit) {
                $config = isset($config[$bit]) ? $config[$bit] : false;
            }
        }

        return $config;
    }
}