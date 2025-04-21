<?php

class Message
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createMessage($name, $email, $message)
    {
        try {
            $this->db->startTransaction();
            $UUID = generateUUID($this->db);

            $sql = "INSERT INTO message (messageID, name, email, message) 
                    VALUES (UNHEX(:uuid), :name, :email, :message)";

            $this->db->query($sql);
            $this->db->bind(':uuid', $UUID, PDO::PARAM_STR);
            $this->db->bind(':name', $name, PDO::PARAM_STR);
            $this->db->bind(':email', $email, PDO::PARAM_STR);
            $this->db->bind(':message', $message, PDO::PARAM_STR);
            
            $this->db->execute();
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

}
