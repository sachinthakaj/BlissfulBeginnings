<?php

class Package
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function fetchWeddingPackages($weddingID)
    {
        try {
            // database query - 3 parts
            $this->db->query("SELECT * FROM packageAssignment 
            JOIN packages ON packageAssignment.packageID = package.packageID 
            LEFT JOIN photographyPackages ON package.packageID = photographyPackages.packageID 
            LEFT JOIN dressmakerPackages ON package.packageID = dressmakerPackages.packageID 
            LEFT JOIN floristPackages ON package.packageID = floristPackages.packageID 
            LEFT JOIN salonPackages ON package.packageID = salonPackages.packageID  
            WHERE packageAssignment.weddingID = :weddingID");
            $this->db->bind(':weddingID', hex2bin($weddingID), PDO::PARAM_LOB);
            $this->db->execute();

            $packageData = $this->db->fetch(PDO::FETCH_ASSOC);
            $packageData['packageID'] = bin2hex($packageData['packageID']);
            $packageData['vendorID'] = bin2hex($packageData['vendorID']);
            return $packageData;
        }
        catch (PDOException $e) {
            error_log($e);
            return false;
        }
    }
}