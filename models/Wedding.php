<?php
// User.php

class Wedding
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance(); // Assuming you have a method to get the PDO instance

    }

    public function fetchDataCustomer($weddingID) {
        
    }

    public function createWedding($weddingDetails, $brideDetails, $groomDetails)
    {
        try {
            $this->db->startTransaction();
            $weddingID =  generateUUID($this->db);
            error_log($weddingID);
            $this->db->query("INSERT INTO wedding (weddingID, userID, date, dayNight, location, theme, sepSalons, sepDressmakers, weddingstate)
             VALUES (UNHEX(:weddingID), :userID, :date, :dayNight, :location, :theme, :sepSalons, :sepDressmakers, 'new')");
            $this->db->bind(':weddingID', $weddingID, PDO::PARAM_LOB);
            $this->db->bind(':userID', $_SESSION['userID']);
            $this->db->bind(':date', $weddingDetails['date']);
            $this->db->bind(':dayNight', $weddingDetails['time']);
            $this->db->bind(':location', $weddingDetails['location']);
            $this->db->bind(':theme', $weddingDetails['theme']);
            $this->db->bind(':sepSalons', $weddingDetails['sepSalons']);
            $this->db->bind(':sepDressmakers', $weddingDetails['sepDressmakers']);
            $this->db->execute();
            error_log(gettype($weddingID));
            
            $brideID = $this->createPerson($brideDetails, "Female", $weddingID);
            $groomID = $this->createPerson($groomDetails, "Male", $weddingID);
            $this->linkWedPersons($weddingID, $brideID, $groomID);
            $this->db->commit();
            return $weddingID;
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            throw new Exception("Transaction failed: " . $e->getMessage());
        }
    }

    private function createPerson($personDetails, $gender) {
        $brideGroomsID = generateUUID($this->db);
        $this->db->query("INSERT INTO brideGrooms(brideGroomsID, name, email, contact, address, gender, age) 
        VALUES (UNHEX(:brideGroomsID), :name, :email, :contact, :address, :gender, :age);");
        $this->db->bind(':brideGroomsID', $brideGroomsID, PDO::PARAM_LOB);
        $this->db->bind(':name', $personDetails['name']);
        $this->db->bind(':email', $personDetails['email']);
        $this->db->bind(':contact', $personDetails['contact']);
        $this->db->bind(':address', $personDetails['address']);
        $this->db->bind(':age', $personDetails['age']);
        $this->db->bind(':gender', $gender);
        $this->db->execute();
        return $brideGroomsID;
    }

    private function linkWedPersons($weddingID, $brideID, $groomID) {
        $this->db->query("INSERT INTO weddingBrideGrooms VALUES (UNHEX(:weddingID), UNHEX(:brideID), UNHEX(:groomID));");
        $this->db->bind(":weddingID", $weddingID, PDO::PARAM_LOB);
        $this->db->bind(":brideID", $brideID, PDO::PARAM_LOB);
        $this->db->bind(":groomID", $groomID, PDO::PARAM_LOB);
        $this->db->execute();
        return;
    }

}
