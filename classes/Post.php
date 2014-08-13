<?php

class Post {

    private $_db,
                $_data,
                $_count = 0,
                $_errors = FALSE;

    public function __construct() {

        $this->_db = DB::getInstance();

    }

    public function find($id = NULL) {
        if ($id) {
            $post = $this->_db->get('posts', array('id', '=', $id));

            if ($post->count()) {
                $this->_data = $post->first();
                $this->_count = $post->count();
                return $this;
            } else {
                $this->_errors = TRUE;
            }
        } else {
            $post = $this->_db->get('posts', FALSE);

            if ($post->count()) {
                $this->_data = $post->results();
                $this->_count = $post->count();
                return $this;
            } else {
                $this->_errors = TRUE;
            }
        }

        return FALSE;
    }

    public function data() {
        return $this->_data;
    }

    public function count() {
        return $this->_count;
    }

    public function errors() {
        return $this->_errors;
    }

}