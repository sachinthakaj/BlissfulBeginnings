<?php

class Vendor
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function emailExists($email)
    {
        $this->db->query('SELECT COUNT(*) FROM vendor WHERE email = :email');
        $this->db->bind(':email',$email,PDO::PARAM_STR);
        $this->db->execute();
        return $this->db->fetchColumn() > 0;
    }
    

    public function createVendor($email,$password,$businessName,$type,$contact,$address,$bankAcc)
    {
        try {
            $UUID= generateUUID($this->db);
            $this->db->query("INSERT INTO vendors (vendorID,email,password,businessName,typeID,contact,address,bankAccDetails) VALUES (UNHEX(:uuid),:email,:password,:businessName,:type,:contact,:address,:bankAcc);");
            $this->db->bind(':uuid',$UUID,PDO::PARAM_LOB);
            $this->db->bind(':email',$email,PDO::PARAM_STR);
            $this->db->bind(':password',$password,PDO::PARAM_STR);
            $this->db->bind(':businessName',$businessName,PDO::PARAM_STR);
            $this->db->bind(':type',$type,PDO::PARAM_STR);
            $this->db->bind(':contact',$contact,PDO::PARAM_STR);
            $this->db->bind(':address',$address,PDO::PARAM_STR);
            $this->db->bind(':bankAcc',$bankAcc,PDO::PARAM_STR);
            $numRows= $this->db->execute();
            error_log("numrows: $numRows");
            if($numRows == 1){
                return $UUID;
            }
            else{
                return 0;
            }
        } catch (Exception $e) {
            echo $e;
            throw new Exception("Error Processing Request", 1);
            
        }
       
    }

    public function getVendorByEmail($email)
    {
        $this->db->query('SELECT * FROM vendor WHERE email= :email');
        $this->db->bind(':email',$email);
        return $this->db->single();
    }
}