<?php

class savedTasks
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getSavedTasks() {
        try {
            $sql = "SELECT * FROM `savedtaskgroups` ";
            $this->db->query($sql);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($result); $i++) {
                $result[$i]['packageID'] = bin2hex($result[$i]['savedTaskGroupID']);
            }
            return $result;
        } catch(Exception $e) {
            error_log($e);
            throw $e;
        }
    }

    public function addNewGroup($groupName, $typeID) {
        try {
            $UUID = generateUUID($this->db);
            $sql = "INSERT INTO `savedtaskgroups`(savedTaskGroupID, savedTaskGroupName, typeID) VALUES (UNHEX(:ID), :name, :typeID)	";
            $this->db->query($sql);
            $this->db->bind(":ID", $UUID, PDO::PARAM_LOB);
            $this->db->bind(":name", $groupName, PDO::PARAM_STR);
            $this->db->bind(":typeID", $typeID, PDO::PARAM_STR);
            $result = $this->db->execute();
            return $result;

        }catch (Exception $e) {
            error_log($e);
            throw( $e);
        }
    }
}
   
    
    



    



