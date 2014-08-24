<?php

class User {
    private $_db,
               $_data,
               $_sessionName,
               $_cookieName,
               $_isLoggedIn;

    public function __construct($user = NULL) {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = TRUE;
                } else {
                    $this->logout();
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception("There was a problem creating a user");
        }
    }

    public function find($user = NULL) {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));
        } else {
            $data = $this->_db->get('users');
        }

        if ($data->count()) {
            $this->_data = ($user) ? $data->first() : $data->results();

            return TRUE;
        }

        return FALSE;
    }

    public function update($fields = array(), $id = NULL) {

        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }

        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception("There was a problem updating");
        }

    }

    public function delete($id = NULL) {

         if (!is_null($id)) {
            $field = (is_numeric($id)) ? 'id' : 'username';

            if (!$this->_db->delete('users', array($field, '=', $id))) {
                throw new Exception("There was a problem deleting the user");
            }
        }

    }

    public function login($username = NULL, $password = NULL, $remember = FALSE) {

        if (!$username && !$password && $this->exists()) {

            Session::put($this->_sessionName, $this->data()->id);

        } else {

            $user = $this->find($username);

            if ($user) {

                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put($this->_sessionName, $this->data()->id);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_sessions', array('user_id', '=', $this->data()->id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_sessions', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return TRUE;

                }
            }
        }

        return FALSE;
    }

    public function hasPermission($key) {
        $group = $this->_db->get('groups', array('id', '=', $this->data()->group));

        if ($group->count()) {

            $permissions = json_decode($group->first()->permissions, TRUE);

            if ($permissions[$key] == TRUE) {
                return TRUE;
            }

        }

        return FALSE;
    }

    public function exists() {
        return (!empty($this->_data)) ? TRUE : FALSE;
    }

    public function logout() {
        $this->_db->delete('users_sessions', array('user_id', '=', $this->data()->id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

}