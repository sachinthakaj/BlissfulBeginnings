<?php

class Reccomendations
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    public function getBrideSalonReccomendations($allocatedBudget) {
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

    public function getGroomSalonReccomendations($allocatedBudget) {
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

    public function getSalonReccomendations($allocatedBudget) {
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

    public function getPhotographerReccomendations($allocatedBudget) {
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

    public function getBrideDressDesignerReccomendations($allocatedBudget) {
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

    public function getGroomDressDesignerReccomendations($allocatedBudget) {
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

    public function getDressDesignerReccomendations($allocatedBudget) {
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

    public function getFloristReccomendations($allocatedBudget) {
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
}