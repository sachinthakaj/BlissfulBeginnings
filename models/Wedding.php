<?php
// User.php

class Wedding
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance(); // Assuming you have a method to get the PDO instance

    }

    public function createWedding($weddingDetails, $brideDetails, $groomDetails)
    {
        try {
            $this->db->startTransaction();
            $this->db->query('INSERT INTO wedding (userID, date, dayNight, location, theme, sepSalons, sepDressmakers, weddingstate)
             VALUES (:userID, :date, :dayNight, :location, :theme, :sepSalons, :sepDressmakers, "new")');
            $this->db->bind(':userID', $_SESSION['userID']);
            $this->db->bind(':date', $weddingDetails['date']);
            $this->db->bind(':dayNight', $weddingDetails['time']);
            $this->db->bind(':location', $weddingDetails['location']);
            $this->db->bind(':theme', $weddingDetails['theme']);
            $this->db->bind(':sepSalons', $weddingDetails['sepSalons']);
            $this->db->bind(':sepDressmakers', $weddingDetails['sepDressmakers']);
            $this->db->execute();
            $weddingID = $this->db->lastId();
            
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
        $this->db->query('INSERT INTO brideGrooms(name, email, contact, address, gender, age) 
        VALUES (:name, :email, :contact, :address, :gender, :age);');
        $this->db->bind(':name', $personDetails['name']);
        $this->db->bind(':email', $personDetails['email']);
        $this->db->bind(':contact', $personDetails['contact']);
        $this->db->bind(':address', $personDetails['address']);
        $this->db->bind(':age', $personDetails['age']);
        $this->db->bind(':gender', $gender);
        $this->db->execute();
        return $this->db->lastId();
    }

    private function linkWedPersons($weddingID, $brideID, $groomID) {
        $this->db->query("INSERT INTO weddingBrideGrooms VALUES ($weddingID, $brideID, $groomID);");
        $this->db->execute();
        return;
    }

}
