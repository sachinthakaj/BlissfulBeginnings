<?php

class Calendar
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function setUnavailableDate($vendorID, $date)
    {
        try {
            error_log("Setting unavailable date for vendor: $vendorID on $date");
            $this->db->startTransaction();
            $dateID = generateUUID($this->db);

            // Check if date is already marked as unavailable
            if ($this->isDateUnavailable($vendorID, $date)) {
                $this->db->rollbackTransaction();
                error_log("Date already marked as unavailable");
                return false;
            }

            $sql = "INSERT INTO unavailabledates (dateID, vendorID, unavailable_date) 
                    VALUES (UNHEX(:dateID), UNHEX(:vendorID), :date)";

            $this->db->query($sql);
            $this->db->bind(':dateID', $dateID, PDO::PARAM_STR);
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->bind(':date', $date, PDO::PARAM_STR);
            $this->db->execute();

            $this->db->commit();
            return $dateID;
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function isDateUnavailable($vendorID, $date)
    {
        $this->db->query("
            SELECT COUNT(*) as count FROM unavailabledates 
            WHERE vendorID = UNHEX(:vendorID) AND unavailable_date = :date
        ");
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $this->db->bind(':date', $date, PDO::PARAM_STR);
        $this->db->execute();

        $result = $this->db->single();
        return $result->count > 0;
    }

    public function getUnavailableDates($vendorID)
    {
        $this->db->query("
            SELECT unavailable_date FROM unavailabledates 
            WHERE vendorID = UNHEX(:vendorID)
            ORDER BY unavailable_date ASC
        ");
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $this->db->execute();

        return $this->db->resultSet(); // Returns all unavailable dates
    }

    public function removeUnavailableDate($vendorID, $date)
    {
        try {
            $this->db->startTransaction();
        
            $this->db->query("
                DELETE FROM unavailabledates 
                WHERE vendorID = UNHEX(:vendorID) AND unavailable_date = :date
            ");
            $this->db->bind(":vendorID", $vendorID, PDO::PARAM_STR);
            $this->db->bind(":date", $date, PDO::PARAM_STR);
            $this->db->execute();
        
            $deletedRows = $this->db->rowCount();
        
            if ($deletedRows > 0) {
                $this->db->commit();
                return true; // Successfully deleted
            } else {
                $this->db->rollbackTransaction();
                error_log("No matching date found to remove");
                return false; // No matching date found
            }
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Delete Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function clearAllUnavailableDates($vendorID)
    {
        try {
            $this->db->startTransaction();
        
            $this->db->query("
                DELETE FROM unavailabledates 
                WHERE vendorID = UNHEX(:vendorID)
            ");
            $this->db->bind(":vendorID", $vendorID, PDO::PARAM_STR);
            $this->db->execute();
        
            $deletedRows = $this->db->rowCount();
            $this->db->commit();
            
            return $deletedRows; // Returns number of dates cleared
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Clear All Error: " . $e->getMessage());
            throw $e;
        }
    }
}