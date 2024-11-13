<?php

class Package
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createPhotographyPackage($packageID, $packageDetails) {
        $this->db->query("INSERT INTO photographyPackages (packageID, cameraCoverage) VALUES (UNHEX(:packageID), :cameraCoverage);");
        $this->db->bind(':packageID', $packageID);
        $this->db->bind(':cameraCoverage', $packageDetails['cameraCoverage']);
        $this->db->execute();
    }

    public function createDressmakerPackage($packageID, $packageDetails) {
        $this->db->query("INSERT INTO dressmakerPackages (packageID, variableCost, theme, demographic) VALUES (UNHEX(:packageID), :variableCost, :dressType, :demographic);");
        $this->db->bind(':packageID', $packageID);
        $this->db->bind(':variableCost', $packageDetails['variableCost']);
        $this->db->bind(':demographic', $packageDetails['demographic']);
        $this->db->bind('theme', $packageDetails['theme']);
        $this->db->execute();
    }

    public function createSalonPackage($packageID, $packageDetails) {
        $this->db->query("INSERT INTO salonPackages (packageID, variableCost, demographic) VALUES (UNHEX(:packageID), :variableCost, :demographic);");
        $this->db->bind(':packageID', $packageID);
        $this->db->bind(':variableCost', $packageDetails['variableCost']);
        $this->db->bind(':demographic', $packageDetails['demographic']);
        $this->db->execute();
    }

    public function createFloristPackage($packageID, $packageDetails) {
        $this->db->query("INSERT INTO floristPackages (packageID, variableCost, flowerType) VALUES (UNHEX(:packageID), :variableCost, :flowerType);");
        $this->db->bind(':packageID', $packageID);
        $this->db->bind(':variableCost', $packageDetails['variableCost']);
        $this->db->bind(':flowerType', $packageDetails['flowerType']);
        $this->db->execute();
    }

    public function createPackage($vendorID, $packageDetails)
    {
        try {
            $this->db->startTransaction();
            $packageID =  generateUUID($this->db);
            error_log($packageID);
            $this->db->query("INSERT INTO packages (packageID, vendorID, name, feature1, feature2, feature3, fixedCost)
             VALUES (UNHEX(:packageID), UNHEX(:vendorID), :name, :feature1, :feature2, :feature3, :fixedCost);");
            $this->db->bind(':packageID', $packageID, PDO::PARAM_LOB);
            $this->db->bind(':vendorID', $vendorID);
            $this->db->bind(':name', $packageDetails['packageName']);
            $this->db->bind(':feature1', $packageDetails['feature1']);
            $this->db->bind(':feature2', $packageDetails['feature2']);
            $this->db->bind(':feature3', $packageDetails['feature3']);  
            $this->db->bind(':fixedCost', $packageDetails['fixedCost']);
            $this->db->execute();


            switch ($packageDetails['type']) {
                case "Photographer":
                    $this->createPhotographyPackage($packageID, $packageDetails);
                    break;
                case "Dressmaker":
                    $this->createDressmakerPackage($packageID, $packageDetails);
                    break;
                case "Salon":
                    $this->createSalonPackage($packageID, $packageDetails);
                    break;
                case "Florist":
                    $this->createFloristPackage($packageID, $packageDetails);
                    break;
                default:
                    throw new Exception("Invalid package type");
            }
            $this->db->commit();
            return $packageID;
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            throw new Exception("Transaction failed: " . $e->getMessage());
        }
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
        } catch (PDOException $e) {
            error_log($e);
            return false;
        }
    }
}
