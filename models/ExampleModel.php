<?php

namespace trimination;

class ExampleModel {
    private Database $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function exampleFn($value, $asObject = false) {
        $query = "SELECT * FROM some_table WHERE value=?";
        if ($asObject)
            return $this->db->query($query, $value)->fetchAll(QueryResultType::asObjects);
        else
            return $this->db->query($query, $value)->fetchAll();
    }
}