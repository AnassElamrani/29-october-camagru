<?php

class Montage {
    
    private $db;

    public function __construct(){
        $this->db = new Database; 
    }

    public function stockImage($data) {
        $this->db->query('INSERT INTO `posts` (`user_id`, `name`) VALUES (:userId , :imgName)');
        $this->db->bind(':userId', $data['userId']);
        $this->db->bind(':imgName', $data['imageName']);
        $this->db->execute();
    }
}

?>