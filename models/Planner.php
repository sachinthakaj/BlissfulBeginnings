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
        $this->db->bind(':email', $email, PDO::PARAM_STR);
        $this->db->execute();
        return $this->db->fetchColumn() > 0;
    }

    public function getNotifications() {
        $this->db->query('SELECT * FROM newvendornotifications UNION SELECT * FROM newpackagenotifications;');
        $this->db->execute();
        $results = $this->db->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $key => $notification) {
            $results[$key]['reference'] = bin2hex($notification['reference']);
            $results[$key]['notificationID'] = bin2hex($notification['notificationID']);
        }
        return $results;
    }

    public function acceptVendor($vendorID) {
        try {
            $this->db->startTransaction();
            $this->db->query('UPDATE vendors SET vendorstate = "Accepted" WHERE vendorID = UNHEX(:vendorID);');
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->execute();
            $this->db->query("DELETE FROM newvendornotifications WHERE reference = UNHEX(:vendorID);");
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->execute();
            $this->db->commit();
            return $this->db->rowCount();
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log($e);
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function rejectVendor($vendorID) {
        try {
            $this->db->startTransaction();
            $this->db->query('DELETE FROM vendors WHERE vendorID = UNHEX(:vendorID);');
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->execute();
            $this->db->query("DELETE FROM newvendornotifications WHERE reference = UNHEX(:vendorID);");
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->execute();
            $this->db->commit();
            return $this->db->rowCount();
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log($e);
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function getPlannerByEmail($email)
    {
        $this->db->query('SELECT * FROM planner WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
        return $this->db->fetch(PDO::FETCH_ASSOC);
    }


    public function getSalonsList()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Salon"');
        $this->db->execute();
        $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getPhotographersList()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="photographer"');
        $this->db->execute();
        $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getDressDesignersList()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Dress Designer"');
        $this->db->execute();
        $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getFloristsList()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Florist"');
        $this->db->execute();
        $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
