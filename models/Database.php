<?php

namespace trimination;
enum QueryResultType {
    case asArray;
    case asAssoc;
    case asObjects;
}

class Database {

    protected $con;
    protected $query;
    protected $queryClosed = true;
    public $queryCount = 0;
    private $error = null;

    public function __construct($charset = 'utf8mb4') {
        $this->con = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->con->connect_error) {
            $this->error("Failed to connect to database: " . $this->con->connect_error);
        }
        $this->con->set_charset($charset);
    }


    public function query($query) {
        $this->error = null;
        if (!$this->queryClosed) {
            $this->query->close();
        }
        if ($this->query = $this->con->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
                $types = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        foreach ($args[$k] as $j => &$a) {
                            $types .= $this->_gettype($args[$k][$j]);
                            $args_ref[] = &$a;
                        }
                    } else {
                        $types .= $this->_gettype($args[$k]);
                        $args_ref[] = &$arg;
                    }
                }
                array_unshift($args_ref, $types);
                call_user_func_array(array($this->query, 'bind_param'), $args_ref);
            }
            $this->query->execute();
            if ($this->query->errno) {
                $this->error($this->query->error);
            }
            $this->queryClosed = false;
            $this->queryCount++;
        } else {
            $this->error($this->con->error);
        }
        return $this;
    }


    public function fetchAll($type = QueryResultType::asAssoc) {
        $params = array();
        $row = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            if ($type === QueryResultType::asObjects) $r = new \stdClass();
            foreach ($row as $key => $val) {
                if ($type === QueryResultType::asObjects) {
                    $r->$key = $val;
                } else if ($type === QueryResultType::asAssoc)
                    $r[$key] = $val;
                else
                    $r[] = $val;
            }
            $result[] = $r;
        }
        $this->query->close();
        $this->queryClosed = true;
        return $result;
    }

    public function close() {
        return $this->con->close();
    }

    public function numRows() {
        $this->query->store_result();
        return $this->query->num_rows;
    }

    public function affectedRows() {
        return $this->query->affected_rows;
    }

    public function lastInsertId() {
        return $this->con->insert_id;
    }

    public function error($error) {
        $this->error = $error;
    }

    public function hasError() {
        return !($this->error === null);
    }

    public function getError() {
        return $this->error;
    }

    private function _gettype($var) {
        if (is_string($var)) return 's';
        if (is_float($var)) return 'd';
        if (is_int($var)) return 'i';
        return 'b';
    }
}