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
            $this->_data = ($post) ? $data->first() : $data->results();
            $this->_count = $data->count();

            return TRUE;
        }

        return FALSE;
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('posts', $fields)) {
            throw new Exception("There was an error creating new post");
        }
    }

    public function update($fields = array(), $id = NULL) {
        if (!$this->_db->update('posts', $id, $fields)) {
            throw new Exception("There was a problem updating the post!");
        }
    }

    public function delete($id = NULL) {
        if (!$this->_db->delete('posts', array('id', '=', $id))) {
            throw new Exception("There was a problem deleting the post");
        }
    }

    public function data() {
        return $this->_data;
    }

    public function count() {
        return $this->_count;
    }

}