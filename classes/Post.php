<?php

class Post {

    private $_db,
                $_data,
                $_count = 0,
                $_errors = FALSE;

    public function __construct($id = null) {
        $this->_db = DB::getInstance();

        if (!$id) {
            $this->findAll();
        } else {
            $this->find($id);
        }
    }

    private function find($id = NULL) {
        if ($id) {
            $post = $this->_db->get('posts', array('id', '=', $id));

            if ($post->count()) {
                $this->_data = $post->first();
                return TRUE;
            } else {
                $this->_errors = TRUE;
            }
        }

        return FALSE;
    }

    private function findAll() {

        if (!$this->_db->getAll('posts')->errors()) {
            $this->_data = $this->_db->results();
            $this->_count = $this->_db->count();

            return TRUE;
        }

        return FALSE;
    }

    public function data() {
        return $this->_data;
    }

    public function count() {
        return $this->_count;
    }

}