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

    public function getEventsForAnAssignment($assignmentID)
    {
        try {
            $this->db->query("SELECT * FROM event WHERE assignmentID=UNHEX(:assignmentID) 
            ORDER BY FIELD(state,'scheduled','finished'), date ASC;");
            $this->db->bind(':assignmentID', $assignmentID, PDO::PARAM_STR);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]["eventID"] = bin2hex($result[$i]["eventID"]);
                $result[$i]["assignmentID"] = bin2hex($result[$i]["assignmentID"]);
            }
            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function updateEvent($eventDetails)
    {
        try {

            $this->db->query("UPDATE event SET description=:description, date=:date WHERE eventID=UNHEX(:eventID);");
            $this->db->bind(':date', $eventDetails['eventDate']);
            $this->db->bind(':description', $eventDetails['eventDescription']);
            $this->db->bind(':eventID', $eventDetails['eventID']);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteEvent($eventDetails)
    {
        try {

            $this->db->query("DELETE FROM event WHERE eventID=UNHEX(:eventID)");
            $this->db->bind(":eventID", $eventDetails['eventID']);
            return $this->db->execute();
        } catch (PDOException $e) {

            error_log($e->getMessage());
            return false;
        }
    }

    public function saveFinishedEvents($eventDetails)
    {
        try {
            $this->db->query("UPDATE event SET state='finished' WHERE eventID=UNHEX(:eventID);");
            $this->db->bind(':eventID', $eventDetails['eventID']);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }


    
}


