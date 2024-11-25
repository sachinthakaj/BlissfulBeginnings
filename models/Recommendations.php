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
            $this->db->query("SELECT packages.* , salonPackages.* FROM salonPackages JOIN Packages ON salonPackages.packageID = Packages.packageID 
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
            $this->db->query("SELECT packages.* , salonPackages.* FROM salonPackages JOIN Packages ON salonPackages.packageID = Packages.packageID 
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
            $this->db->query("SELECT packages.* , salonPackages.* FROM salonPackages JOIN Packages ON salonPackages.packageID = Packages.packageID 
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
            $this->db->query("SELECT packages.* , photographyPackages.* FROM photographyPackages JOIN Packages ON photographyPackages.packageID = Packages.packageID 
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
            $this->db->query("SELECT packages.* , dressDesignerPackages.* FROM dressDesignerPackages JOIN Packages ON dressDesignerPackages.packageID = Packages.packageID 
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
            $this->db->query("SELECT packages.* , dressDesignerPackages.* FROM dressDesignerPackages JOIN Packages ON dressDesignerPackages.packageID = Packages.packageID 
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
            $this->db->query("SELECT packages.* , dressDesignerPackages.* FROM dressDesignerPackages JOIN Packages ON dressDesignerPackages.packageID = Packages.packageID 
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
            $this->db->query("SELECT packages.* , floristPackages.* FROM floristPackages JOIN Packages ON floristPackages.packageID = Packages.packageID 
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
            $this->db->query('UPDATE wedding SET state = "unassigned" WHERE weddingID = UNHEX(:weddingID)');
            $this->db->bind(':weddingID', $weddingID);
            $this->db->execute();
            foreach ($selectedPackages as $typeID => $packages) {
                foreach ($packages as $packageID) {
                        $this->db->query('INSERT INTO recommendations (weddingID, packageID, typeID) VALUES (UNHEX(:weddingID), UNHEX(:packageID), :typeID)');
                    $this->db->bind(':weddingID', $weddingID);
                    $this->db->bind(':packageID', $packageID);
                    $this->db->bind(':typeID', $typeID);
                    error_log("weddingID: ". $weddingID." packageID: ". $packageID." typeID: ". $typeID);
                    $this->db->execute();
                    $result = $this->db->rowCount();
                    error_log($result);
                    return $result;
                }
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log($e);
        }
    }
}