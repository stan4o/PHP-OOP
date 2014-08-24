<?php

class DB {

    private static $_instance = NULL;
    private $_pdo,
               $_query,
               $_errors = FALSE,
               $_results,
               $_count = 0;

    private function __construct() {
        try {
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
            );

            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'), $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

     public function query($sql, $params=array()) {
        $this->_errors = FALSE;

        if ($this->_query = $this->_pdo->prepare($sql)) {
            $pos = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($pos, $param);
                    $pos++;
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_errors = TRUE;
            }
      }

        return $this;
    }

    public function action($action, $table, $where = array()) {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '<=', '>=');

            $field       = $where[0];
            $operator = $where[1];
            $value      = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->errors()) {
                    return $this;
                }
            }

        }

        return FALSE;
    }

    public function get($table, $where = FALSE,  $columns = NULL) {
        if ($where) {
            return $this->action('SELECT *', $table, $where);
        } else {
            if (!is_null($columns) && is_array($columns)) {
                $selected_columns = "`" . implode("`, `", $columns) . "`";
            } else {
                $selected_columns = "*";
            }

            $sql = "SELECT {$selected_columns} FROM {$table}";

            if (!$this->query($sql)->errors()) {
                return $this;
            }
        }

        return FALSE;
    }

    public function delete($table, $where) {
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, $fields = array()) {
        if (count($fields)) {
            $keys = array_keys($fields);
            $values = "";
            $pos = 1;

            foreach ($fields as $field) {
                $values .= "?";

                if ($pos < count($fields)) {
                    $values .= ", ";
                }

                $pos ++;
            }

            $sql = "INSERT INTO {$table} (`" . implode("`, `", $keys) . "`) VALUES ({$values})";
            if (!$this->query($sql, $fields)->errors()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function update($table, $id, $fields = array()) {
        $set = "";
        $pos = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($pos < count($fields)) {
                $set .= ", ";
            }
            $pos ++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if (!$this->query($sql, $fields)->errors()) {
            return TRUE;
        }

        return FALSE;
    }

    public function results() {
        return $this->_results;
    }

    public function first() {
        return $this->results()[0];
    }

    public function errors() {
        return $this->_errors;
    }

    public function count() {
        return $this->_count;
    }
}