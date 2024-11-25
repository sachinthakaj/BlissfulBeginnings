<?php

class Task
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    public function getAssignmentIDfroAVendorofAWedding($weddingID, $vendorID)
    {
        try {
            $this->db->query("SELECT pa.assignmentID
        FROM packageAssignment pa
        JOIN packages p ON pa.packageID=p.packageID
        JOIN vendors v ON p.vendorID=v.vendorID
        WHERE pa.weddingID=UNHEX(:weddingID) AND v.vendorID=UNHEX(:vendorID)");

            $this->db->bind(":weddingID", $weddingID, PDO::PARAM_STR);
            $this->db->bind(":vendorID", $vendorID, PDO::PARAM_STR);
            $this->db->execute();
            $result = $this->db->fetch(PDO::FETCH_ASSOC);
            $result["assignmentID"] = bin2hex($result["assignmentID"]);

            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function createTask($taskDetails)
    {
        try {
            $taskID = generateUUID($this->db);
            $this->db->query("INSERT INTO task(taskID,assignmentID,dateToFinish,description,state)
            VALUES (UNHEX(:taskID),UNHEX(:assignmentID),:dateToFinish,:description,'ongoing');");
            $this->db->bind(':taskID', $taskID);
            $this->db->bind(':assignmentID', $taskDetails['assignmentID']);
            $this->db->bind(':dateToFinish', $taskDetails['dateToFinish']);
            $this->db->bind(':description', $taskDetails['description']);

            $this->db->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function updateTask($taskDetails)
    {
        try {

            $this->db->query("UPDATE task SET description=:description, dateToFinish=:dateToFinish WHERE taskID=UNHEX(:taskID);");
            $this->db->bind(':dateToFinish', $taskDetails['dateToFinish']);
            $this->db->bind(':description', $taskDetails['description']);
            $this->db->bind(':taskID', $taskDetails['taskID']);
            $this->db->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteTask($taskID)
    {
        try {
            
            $this->db->query("DELETE FROM task WHERE taskID=UNHEX(:taskID)");
            $this->db->bind(":taskID", $taskID, PDO::PARAM_LOB);
            $this->db->execute();
        } catch (PDOException $e) {

            error_log($e->getMessage());
            return false;
        }
    }

    public function getAllTasks($assignmentID)
    {

        try {
            $this->db->query("SELECT taskID,description,dateToFinish FROM task WHERE assignmentID=UNHEX(:assignmentID) ORDER BY dateToFinish ASC;");
            $this->db->bind(':assignmentID', $assignmentID, PDO::PARAM_STR);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]["taskID"] = bin2hex($result[$i]["taskID"]);
            }
            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
