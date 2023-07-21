<?php

namespace trimination;

class PostsModel {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getPostBySlug($slug, $asObject = false) {
        $query = "SELECT * FROM posts WHERE slug=?";
        if ($asObject)
            return $this->db->query($query, $slug)->fetchAll(QueryResultType::asObjects);
        else
            return $this->db->query($query, $slug)->fetchAll();
    }
}