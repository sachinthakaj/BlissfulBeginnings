<?php
// User.php

class User
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance(); // Assuming you have a method to get the PDO instance

    }

    public function emailExists($email)
    {
        $this->db->query('SELECT COUNT(*) FROM users WHERE email = :email');
        $this->db->bind(':email', $email, PDO::PARAM_STR);
        $this->db->execute();
        return $this->db->fetchColumn() > 0;
    }

    public function createUser($email, $password)
    {   $UUID = generateUUID($this->db);
        $this->db->query("INSERT INTO users (userID, email, password) VALUES (UNHEX(:uuid), :email, :password)");
        $this->db->bind(':uuid', $UUID, PDO::PARAM_STR);
        $this->db->bind(':email', $email, PDO::PARAM_STR);
        $this->db->bind(':password', $password, PDO::PARAM_STR);
        $numRows = $this->db->execute();
        error_log("numrows: $numRows");
        if($numRows == 1) {
            return $UUID;
        } else {
            return 0;
        }
    }

    public function getUserByEmail($email)
    {
        $this->db->query('SELECT * FROM wedding RIGHT JOIN users on wedding.userID = users.userID WHERE email = :email');
        $this->db->bind(':email',$email);
        $this->db->execute();   
        $result = $this->db->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
