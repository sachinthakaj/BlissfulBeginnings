<?php

class Recommendations
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    public function getBrideSalonRecommendations($allocatedBudget, $numFemaleGroup, $weddingDate)
    {
        try {
            $this->db->query("SELECT packages.* , salonPackages.*, vendors.businessName,
            packages.fixedCost + salonPackages.variableCostPerFemale * :numFemaleGroup as total_price
            FROM salonPackages 
            JOIN Packages ON salonPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            LEFT JOIN unavailableDates ON vendors.vendorID = unavailableDates.vendorID AND unavailableDates.unavailable_date = :weddingDate
            WHERE packages.fixedCost + salonPackages.variableCostPerFemale * :numFemaleGroup <= :allocatedBudget 
            AND salonPackages.demographic != 'Groom'
            AND unavailableDates.vendorID IS NULL
            ;");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->bind(":numFemaleGroup", $numFemaleGroup);
            $this->db->bind(":weddingDate", $weddingDate);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $controller = new PackageController();
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['path'] = $controller->getImageForPackage(bin2hex($result[$i]['packageID']))["path"];
            }
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getGroomSalonRecommendations($allocatedBudget, $numMaleGroup, $weddingDate)
    {
        try {
            $this->db->query("SELECT packages.* , salonPackages.*, vendors.businessName,
            packages.fixedCost + salonPackages.variableCostPerMale * :numMaleGroup as total_price
            FROM salonPackages 
            JOIN Packages ON salonPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            LEFT JOIN unavailableDates ON vendors.vendorID = unavailableDates.vendorID AND unavailableDates.unavailable_date = :weddingDate
            WHERE packages.fixedCost + salonPackages.variableCostPerMale * :numMaleGroup <= :allocatedBudget 
            AND salonPackages.demographic != 'Bride'
            AND unavailableDates.vendorID IS NULL
                ;");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->bind(":numMaleGroup", $numMaleGroup);
            $this->db->bind(":weddingDate", $weddingDate);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $controller = new PackageController();
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['path'] = $controller->getImageForPackage(bin2hex($result[$i]['packageID']))["path"];
            }
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getSalonRecommendations($allocatedBudget, $numMaleGroup, $numFemaleGroup, $weddingDate)
    {
        try {
            $this->db->query("SELECT packages.* , salonPackages.*, vendors.businessName,
            packages.fixedCost + salonPackages.variableCostPerFemale * :numFemaleGroup + salonPackages.variableCostPerMale * :numMaleGroup as total_price
            FROM salonPackages 
            JOIN Packages ON salonPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            LEFT JOIN unavailableDates ON vendors.vendorID = unavailableDates.vendorID AND unavailableDates.unavailable_date = :weddingDate
            WHERE packages.fixedCost + salonPackages.variableCostPerFemale * :numFemaleGroup + salonPackages.variableCostPerMale * :numMaleGroup <= :allocatedBudget 
            AND salonPackages.demographic = 'Both'
            AND unavailableDates.vendorID IS NULL
            ;");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->bind(":numMaleGroup", $numMaleGroup);
            $this->db->bind(":numFemaleGroup", $numFemaleGroup);
            $this->db->bind(":weddingDate", $weddingDate);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $controller = new PackageController();
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['path'] = $controller->getImageForPackage(bin2hex($result[$i]['packageID']))["path"];
            }
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getPhotographerRecommendations($allocatedBudget, $weddingDate)
    {
        try {
            $this->db->query("SELECT packages.* , photographyPackages.*, vendors.businessName, packages.fixedCost as total_price  FROM photographyPackages 
            JOIN Packages ON photographyPackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            LEFT JOIN unavailableDates ON vendors.vendorID = unavailableDates.vendorID AND unavailableDates.unavailable_date = :weddingDate
            WHERE packages.fixedCost <= :allocatedBudget
            AND unavailableDates.vendorID IS NULL
            ;");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->bind(":weddingDate", $weddingDate);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $controller = new PackageController();
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['path'] = $controller->getImageForPackage(bin2hex($result[$i]['packageID']))["path"];
            }
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getBrideDressDesignerRecommendations($allocatedBudget, $numFemaleGroup, $weddingDate)
    {
        try {
            $this->db->query("SELECT packages.* , dressDesignerPackages.*, vendors.businessName,
            packages.fixedCost + dressdesignerpackages.variableCostPerFemale * :numFemaleGroup as total_price
            FROM dressdesignerpackages
            JOIN Packages ON dressdesignerpackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            LEFT JOIN unavailableDates ON vendors.vendorID = unavailableDates.vendorID AND unavailableDates.unavailable_date = :weddingDate
            WHERE packages.fixedCost + dressdesignerpackages.variableCostPerFemale * :numFemaleGroup <= :allocatedBudget 
            AND dressDesignerPackages.demographic != 'Groom'
            AND unavailableDates.vendorID IS NULL
            ;");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->bind(":numFemaleGroup", $numFemaleGroup);
            $this->db->bind(":weddingDate", $weddingDate);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $controller = new PackageController();
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['path'] = $controller->getImageForPackage(bin2hex($result[$i]['packageID']))["path"];
            }
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getGroomDressDesignerRecommendations($allocatedBudget, $numMaleGroup, $weddingDate)
    {
        try {
            $this->db->query("SELECT packages.* , dressDesignerPackages.*, vendors.businessName,
            packages.fixedCost + dressdesignerpackages.variableCostPerMale * :numMaleGroup as total_price
            FROM dressdesignerpackages
            JOIN Packages ON dressdesignerpackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            LEFT JOIN unavailableDates ON vendors.vendorID = unavailableDates.vendorID AND unavailableDates.unavailable_date = :weddingDate
            WHERE packages.fixedCost + dressdesignerpackages.variableCostPerMale * :numMaleGroup <= :allocatedBudget 
            AND dressDesignerPackages.demographic != 'Bride'
            AND unavailableDates.vendorID IS NULL;
            ");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->bind(":numMaleGroup", $numMaleGroup);
            $this->db->bind(":weddingDate", $weddingDate);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $controller = new PackageController();
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['path'] = $controller->getImageForPackage(bin2hex($result[$i]['packageID']))["path"];
            }
            return $result;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getDressDesignerRecommendations($allocatedBudget, $numMaleGroup, $numFemaleGroup, $weddingDate)
    {
        try {
            $this->db->query("SELECT packages.* , dressDesignerPackages.*, vendors.businessName,
            packages.fixedCost + dressdesignerpackages.variableCostPerMale * :numMaleGroup + dressdesignerpackages.variableCostPerFemale * :numFemaleGroup as total_price
            FROM dressdesignerpackages
            JOIN Packages ON dressdesignerpackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            LEFT JOIN unavailableDates ON vendors.vendorID = unavailableDates.vendorID AND unavailableDates.unavailable_date = :weddingDate
            WHERE packages.fixedCost + dressdesignerpackages.variableCostPerMale * :numMaleGroup + dressdesignerpackages.variableCostPerFemale * :numFemaleGroup <= :allocatedBudget 
            AND dressDesignerPackages.demographic != 'Bride'
            AND unavailableDates.vendorID IS NULL
            ;");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->bind(":numMaleGroup", $numMaleGroup);
            $this->db->bind(":numFemaleGroup", $numFemaleGroup);    
            $this->db->bind(":weddingDate", $weddingDate);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $controller = new PackageController();
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['path'] = $controller->getImageForPackage(bin2hex($result[$i]['packageID']))["path"];
            }
            return $result;
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }
    }

    public function getFloristRecommendations($allocatedBudget, $numFemaleGroup, $weddingDate)
    {
        try {
            $this->db->query("SELECT packages.* , floristPackages.*, vendors.businessName,
            packages.fixedCost + floristpackages.variableCostPerFemale * :numFemaleGroup as total_price
            FROM floristpackages
            JOIN Packages ON floristpackages.packageID = Packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            LEFT JOIN unavailableDates ON vendors.vendorID = unavailableDates.vendorID AND unavailableDates.unavailable_date = :weddingDate
            WHERE packages.fixedCost + floristpackages.variableCostPerFemale * :numFemaleGroup <= :allocatedBudget 
            AND unavailableDates.vendorID IS NULL;
            ");
            $this->db->bind(":allocatedBudget", $allocatedBudget);
            $this->db->bind(":numFemaleGroup", $numFemaleGroup);
            $this->db->bind(":weddingDate", $weddingDate);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $controller = new PackageController();
            for ($i = 0; $i < count($result); $i++) {
                error_log($result[$i]['packageID']);
                $result[$i]['path'] = $controller->getImageForPackage(bin2hex($result[$i]['packageID']))["path"];
            }
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
                foreach ($packages as $package) {
                    $this->db->query('INSERT INTO recommendations (weddingID, packageID, typeID, price) VALUES (UNHEX(:weddingID), UNHEX(:packageID), :typeID, :price)');
                    $this->db->bind(':weddingID', $weddingID);
                    $this->db->bind(':packageID', $package['id']); 
                    error_log($package['price']); 
                    $this->db->bind(':price', $package['price']);
                    $this->db->bind(':typeID', $typeID);
                    error_log("weddingID: " . $weddingID . " packageID: " . $package['id'] . " typeID: " . $typeID);
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

    public function getTheValueOfUpfrontPayment($weddingID){
        try {
            $this->db->query("SELECT SUM(p.fixedCost) as totalRecomPackageCost,p.packageName from packages p 
            JOIN recommendations r ON p.packageID = r.pacakgeID
            WHERE r.weddingID = UNHEX(:weddingID);");
            $this->db->bind(':weddingID', $weddingID);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
