<?php

class Planner
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function emailExists($email)
    {
        $this->db->query('SELECT COUNT(*) FROM planner WHERE email = :email');
        $this->db->bind(':email',$email,PDO::PARAM_STR);
        $this->db->execute();
        return $this->db->fetchColumn() > 0;
    }

    public function getPlannerByEmail($email)
    {
        $this->db->query('SELECT * FROM planner WHERE email= :email');
        $this->db->bind(':email',$email);
        return $this->db->fetch(PDO::FETCH_ASSOC);
    }
    public function getVendorList(){
        $this->db->query('SELECT * FROM vendors');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }

}