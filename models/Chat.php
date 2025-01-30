<?php

class Chat
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    public function getMessages($weddingID)
    {
        try {
            $this->db->query("SELECT role, message, timestamp, imagereference FROM chat WHERE weddingID = :weddingID ORDER BY timestamp ASC;");
            $this->db->bind(':weddingID', hex2bin($weddingID), PDO::PARAM_LOB);
            $this->db->execute();
            $messages = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $messages;
        } catch (PDOException $e) {
            error_log($e);
            return false;
        }
    }

    public function saveMessage($weddingID, $role, $timestamp, $message)
    {
        try {
            $messageID = generateUUID($this->db);
            $this->db->query("INSERT INTO chat (messageID, weddingID, role, timestamp, message) VALUES (:messageID,:weddingID, :role, :timestamp, :message);");
            $this->db->bind(':messageID', hex2bin($messageID), PDO::PARAM_LOB);
            $this->db->bind(':weddingID', hex2bin($weddingID), PDO::PARAM_LOB);
            $this->db->bind(':role', $role, PDO::PARAM_STR);
            $this->db->bind(':timestamp', $timestamp, PDO::PARAM_STR);
            $this->db->bind(':message', $message, PDO::PARAM_STR);
            $this->db->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e);
            return false;
        }
    }

    public function logImageUpload($weddingID, $relativePath, $metadata)
    {
        try {
            $this->db->query("INSERT INTO chatImages (weddingID) VALUES (:weddingID);");
            $this->db->bind(':weddingID', hex2bin($weddingID), PDO::PARAM_LOB);
            $this->db->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e);
            return false;
        }
    }
    public function saveImageMessage($weddingID, $relativePath, $timestamp, $sender)
    {
        try {
            $messageID = generateUUID($this->db);
            $this->db->query("INSERT INTO chat (messageID, weddingID, role, timestamp, relativePath) VALUES (:messageID,:weddingID, :role, :timestamp, :relativePath);");
            $this->db->bind(':messageID', hex2bin($messageID), PDO::PARAM_LOB);
            $this->db->bind(':weddingID', hex2bin($weddingID), PDO::PARAM_LOB);
            $this->db->bind(':role', $sender, PDO::PARAM_STR);
            echo "timestamp: " . $timestamp;
            $this->db->bind(':timestamp', $timestamp, PDO::PARAM_STR);
            $this->db->bind(':relativePath', $relativePath, PDO::PARAM_STR);
            $this->db->execute();
            echo "Successfully logged the image";
            return true;
        } catch (Exception $e) {
            echo "There is an error";
            error_log($e);
        }
    }
}
