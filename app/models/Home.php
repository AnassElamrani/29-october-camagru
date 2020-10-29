<?php

class Home {
    private $db;
    public function __construct() {
        $this->db = new Database;
    }

    public function getImages() {
        $this->db->query('SELECT `name` FROM posts');
        return $this->db->resultset();
    }
}

?>