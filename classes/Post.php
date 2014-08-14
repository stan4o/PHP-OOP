<?php

class Post {

    private $_db,
                $_data,
                $_count = 0;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function find($post = NULL) {
        if ($post) {
            $field = (is_numeric($post)) ? 'id' : 'title';
            $data = $this->_db->get('posts', array($field, '=', $post));
        } else {
            $data = $this->_db->get('posts');
        }

        if ($data->count()) {
            $this->_data = ($data->count() == 1) ? $data->first() : $data->results();
            $this->_count = $data->count();

            return TRUE;
        }

        return FALSE;
    }

    public function update($fields = array(), $id = NULL) {
        if (!$id) {
            $id = Input::get('article');
        }

        if (!$this->_db->update('posts', $id, $fields)) {
            throw new Exception("There was a problem editing the post!");
        }
    }

    public function data() {
        return $this->_data;
    }

    public function count() {
        return $this->_count;
    }

}