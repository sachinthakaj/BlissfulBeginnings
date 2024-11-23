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
}