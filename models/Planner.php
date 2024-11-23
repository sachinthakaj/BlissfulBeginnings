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
        $this->db->query('SELECT * FROM planner WHERE email = :email');
        $this->db->bind(':email',$email);
        $this->db->execute();
        return $this->db->fetch(PDO::FETCH_ASSOC);
    }
   
    
    public function getSalonsList(){
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Salon"');
        $this->db->execute();
        $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }
    public function getPhotographersList(){
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="photographer"');
        $this->db->execute();
        $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getDressDesignersList(){
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Dress Designer"');
        $this->db->execute();
        $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getFloristsList(){
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Florist"');
        $this->db->execute();
        $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}