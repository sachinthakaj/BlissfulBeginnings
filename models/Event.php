<?php

class Event
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createEvent($eventDetails)
    {
        try {
            $eventID = generateUUID($this->db);
            $this->db->query("INSERT INTO event(eventID,assignmentID,description,date,state)
            VALUES (UNHEX(:eventID),UNHEX(:assignmentID),:description,:date,'scheduled');");
            $this->db->bind(':eventID', $eventID);
            $this->db->bind(':assignmentID', $eventDetails['assignmentID']);
            $this->db->bind(':description', $eventDetails['eventDescription']);
            $this->db->bind(':date', $eventDetails['eventDate']);

            return $this->db->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
   
    
    



    
}


