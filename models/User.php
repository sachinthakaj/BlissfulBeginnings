<?php
// User.php

class User {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // Assuming you have a method to get the PDO instance
    }

    public function emailExists($email) {
        $this->db->query('SELECT COUNT(*) FROM users WHERE email = :email');
        $this->db->bind(':email', $email, PDO::PARAM_STR);
        $this->db->execute();
        return $this->db->fetchColumn() > 0;
    }

    public function createUser($email, $password) {
        $stmt = $this->db->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
