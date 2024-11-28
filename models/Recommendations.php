<?php

class Recommendations
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    public function getBrideSalonRecommendations($allocatedBudget) {
        try {
            $this->db->query("SELECT packages.* , salonPackages.*, vendors.businessName  FROM salonPackages 
            JOIN Packages ON salonPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packages.fixedCost <= :allocatedBudget AND salonPackages.demographic != 'Groom';");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getGroomSalonRecommendations($allocatedBudget) {
        try {
            $this->db->query("SELECT packages.* , salonPackages.*, vendors.businessName  FROM salonPackages 
            JOIN Packages ON salonPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packages.fixedCost <= :allocatedBudget AND salonPackages.demographic != 'Bride';");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getSalonRecommendations($allocatedBudget) {
        try {
            $this->db->query("SELECT packages.* , salonPackages.*, vendors.businessName  FROM salonPackages 
            JOIN Packages ON salonPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packages.fixedCost <= :allocatedBudget AND salonPackages.demographic = 'Both';");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getPhotographerRecommendations($allocatedBudget) {
        try {
            $this->db->query("SELECT packages.* , photographyPackages.*, vendors.businessName  FROM photographyPackages 
            JOIN Packages ON photographyPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packages.fixedCost <= :allocatedBudget;");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getBrideDressDesignerRecommendations($allocatedBudget) {
        try {
            $this->db->query("SELECT packages.* , dressDesignerPackages.*, vendors.businessName  FROM dressDesignerPackages 
            JOIN Packages ON dressDesignerPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packages.fixedCost <= :allocatedBudget AND dressDesignerPackages.demographic != 'Groom';");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getGroomDressDesignerRecommendations($allocatedBudget) {
        try {
            $this->db->query("SELECT packages.* , dressDesignerPackages.*, vendors.businessName  FROM dressDesignerPackages 
            JOIN Packages ON dressDesignerPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packages.fixedCost <= :allocatedBudget AND dressDesignerPackages.demographic != 'Bride';");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getDressDesignerRecommendations($allocatedBudget) {
        try {
            $this->db->query("SELECT packages.* , dressDesignerPackages.*, vendors.businessName  FROM dressDesignerPackages 
            JOIN Packages ON dressDesignerPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packages.fixedCost <= :allocatedBudget AND dressDesignerPackages.demographic = 'Both';");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getFloristRecommendations($allocatedBudget) {
        try {
            $this->db->query("SELECT packages.* , floristPackages.*, vendors.businessName FROM floristPackages 
            JOIN Packages ON floristPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packages.fixedCost <= :allocatedBudget ;");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function createRecommendations($weddingID, $selectedPackages)
    {
        try {
            $this->db->startTransaction();
            $this->db->query('UPDATE wedding SET weddingState = "unassigned" WHERE weddingID = UNHEX(:weddingID)');
            $this->db->bind(':weddingID', $weddingID);
            $this->db->execute();
            $result = 0;
            foreach ($selectedPackages as $typeID => $packages) {
                foreach ($packages as $packageID) {
                        $this->db->query('INSERT INTO recommendations (weddingID, packageID, typeID) VALUES (UNHEX(:weddingID), UNHEX(:packageID), :typeID)');
                    $this->db->bind(':weddingID', $weddingID);
                    $this->db->bind(':packageID', $packageID);
                    $this->db->bind(':typeID', $typeID);
                    error_log("weddingID: ". $weddingID." packageID: ". $packageID." typeID: ". $typeID);
                    $this->db->execute();
                    $result += $this->db->rowCount();
                    error_log($result);
                }
            }
            $this->db->commit();
            return $result;
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log($e);
        }
    }
}