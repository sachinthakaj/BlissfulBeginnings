<?php

class Package
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createPhotographyPackage($packageID, $packageDetails)
    {
        $this->db->query("INSERT INTO photographyPackages (packageID, cameraCoverage) VALUES (UNHEX(:packageID), :cameraCoverage);");
        $this->db->bind(':packageID', $packageID);
        $this->db->bind(':cameraCoverage', $packageDetails['cameraCoverage']);
        $this->db->execute();
    }

    public function createDressDesignerPackage($packageID, $packageDetails)
    {
        $this->db->query("INSERT INTO dressDesignerPackages (packageID, variableCostPerMale, variableCostPerFemale, theme, demographic) VALUES (UNHEX(:packageID), :variableCostPerMale, :variableCostPerFemale, :theme, :demographic);");
        $this->db->bind(':packageID', $packageID);
        $this->db->bind(':variableCostPerMale', $packageDetails['variableCostPerMale']);
        $this->db->bind(':variableCostPerFemale', $packageDetails['variableCostPerFemale']);
        $this->db->bind(':demographic', $packageDetails['demographic']);
        $this->db->bind(':theme', $packageDetails['theme']);
        $this->db->execute();
    }

    public function createSalonPackage($packageID, $packageDetails)
    {
        $this->db->query("INSERT INTO salonPackages (packageID, variableCostPerMale, variableCostPerFemale, demographic) VALUES (UNHEX(:packageID), :variableCostPerMale, :variableCostPerFemale, :demographic);");
        $this->db->bind(':packageID', $packageID);
        $this->db->bind(':variableCostPerMale', $packageDetails['variableCostPerMale']);
        $this->db->bind(':variableCostPerFemale', $packageDetails['variableCostPerFemale']);
        $this->db->bind(':demographic', $packageDetails['demographic']);
        $this->db->execute();
    }

    public function createFloristPackage($packageID, $packageDetails)
    {
        $this->db->query("INSERT INTO floristPackages (packageID, variableCostPerFemale, flowerType) VALUES (UNHEX(:packageID), :variableCostPerFemale, :flowerType);");
        $this->db->bind(':packageID', $packageID);
        $this->db->bind(':variableCostPerFemale', $packageDetails['variableCostPerFemale']);
        $this->db->bind(':flowerType', $packageDetails['flowerType']);
        $this->db->execute();
        error_log("Package ID in Florist: " . $packageID);
    }

    public function createPackage($vendorID, $packageDetails)
    {
        try {
            $this->db->startTransaction();
            $packageID =  generateUUID($this->db);
            $this->db->query("INSERT INTO packages (packageID, vendorID, packageName, feature1, feature2, feature3, fixedCost)
             VALUES (UNHEX(:packageID), UNHEX(:vendorID), :packageName, :feature1, :feature2, :feature3, :fixedCost);");
            $this->db->bind(':packageID', $packageID, PDO::PARAM_LOB);
            $this->db->bind(':vendorID', $vendorID);
            $this->db->bind(':packageName', $packageDetails['packageName']);
            $this->db->bind(':feature1', $packageDetails['feature1']);
            $this->db->bind(':feature2', $packageDetails['feature2']);
            $this->db->bind(':feature3', $packageDetails['feature3']);
            $this->db->bind(':fixedCost', $packageDetails['fixedCost']);
            $this->db->execute();


            switch ($packageDetails['typeID']) {
                case "Photographer":
                    $this->createPhotographyPackage($packageID, $packageDetails);
                    break;
                case "Dress Designer":
                    $this->createDressDesignerPackage($packageID, $packageDetails);
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

    public function getPackages($vendorID, $type)
    {
        switch ($type) {
            case "Photographer":
                $this->getPhotographerPackages($vendorID);
                break;
            case "Dress Designer":
                $this->getDressDesignerPackages($vendorID);
                break;
            case "Salon":
                $this->getSalonPackages($vendorID);
                break;
            case "Florist":
                $this->getFloristPackages($vendorID);
                break;
            default:
                throw new Exception("Data Integrity Violated", 1);
        }
        $packageDetails = [];
        while ($row = $this->db->fetch(PDO::FETCH_ASSOC)) {
            $packageID = bin2hex($row['packageID']);
            unset($row['packageID'], $row['vendorID']);
            $packageDetails[$packageID] = $row;
        }
        return $packageDetails;
    }

    public function getPhotographerPackages($vendorID)
    {
        $this->db->query("SELECT packages.*, photographyPackages.* FROM photographyPackages INNER JOIN packages ON photographyPackages.packageID = packages.packageID 
        INNER JOIN vendors ON packages.vendorID = vendors.vendorID
        WHERE packages.vendorID = UNHEX(:vendorID);");
        $this->db->bind(':vendorID', $vendorID);
        $this->db->execute();
        return;
    }

    public function getDressDesignerPackages($vendorID)
    {
        $this->db->query("SELECT * FROM dressDesignerPackages INNER JOIN packages ON dressDesignerPackages.packageID = packages.packageID 
        INNER JOIN vendors ON packages.vendorID = vendors.vendorID
        WHERE packages.vendorID = UNHEX(:vendorID);");
        $this->db->bind(':vendorID', $vendorID);
        $this->db->execute();
    }

    public function getSalonPackages($vendorID)
    {
        $this->db->query("SELECT * FROM salonPackages INNER JOIN packages ON salonPackages.packageID = packages.packageID 
        INNER JOIN vendors ON packages.vendorID = vendors.vendorID
        WHERE packages.vendorID = UNHEX(:vendorID);");
        $this->db->bind(':vendorID', $vendorID);
        $this->db->execute();
    }

    public function getFloristPackages($vendorID)
    {
        $this->db->query("SELECT * FROM floristPackages INNER JOIN packages ON floristPackages.packageID = packages.packageID 
        INNER JOIN vendors ON packages.vendorID = vendors.vendorID
        WHERE packages.vendorID = UNHEX(:vendorID);");
        $this->db->bind(':vendorID', $vendorID);
        $this->db->execute();
    }

    public function updatePackage($vendorID, $packageID, $updatedPackageDetails)
    {
        try {
            $this->db->startTransaction();
            $setPart = [];
            $params = [];
            foreach ($updatedPackageDetails["changedGeneralFields"] as $column => $value) {
                $setPart[] = "$column = :$column";
                $params[":$column"] = $value;
            }
            $params[':packageID'] = hex2bin($packageID);
            $setPartString = implode(', ', $setPart);
            $sql = "UPDATE packages SET $setPartString WHERE packageID = :packageID";
            error_log($sql);
            $this->db->query($sql);
            $this->db->execute($params);
            $this->db->commit();
            return $packageID;
        } catch (PDOException $e) {
            error_log($e);
            return false;
        }
    }


    public function fetchWeddingPackages($weddingID)
    {
        try {
            // database query - 3 parts
            $this->db->query("SELECT * FROM packageAssignment 
            JOIN packages ON packageAssignment.packageID = package.packageID 
            LEFT JOIN photographyPackages ON package.packageID = photographyPackages.packageID 
            LEFT JOIN dressDesignerPackages ON package.packageID = dressDesignerPackages.packageID 
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

    public function fetchRecommendations($weddingID)
    {
        try {
            $this->db->query('SELECT p.*, r.price, r.typeID as typeID
            FROM recommendations AS r JOIN packages AS p ON r.packageID=p.packageID WHERE r.weddingID=UNHEX(:weddingID);');
            $this->db->bind(':weddingID', $weddingID);
            $this->db->execute();
            $queryResults =  $this->db->fetchAll(PDO::FETCH_ASSOC);
            $results = [];
            foreach ($queryResults as $row) {
                $row['packageID'] = bin2hex($row['packageID']);
                $row['vendorID'] = bin2hex($row['vendorID']);
                $results[$row['typeID']][] = $row;
            }
            return $results;
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function setPackages($weddingID, $packages)
    {
        try {
            $this->db->startTransaction();
            foreach ($packages as $typeID => $package) {
                $assignmentID = generateUUID($this->db);
                $this->db->query('INSERT INTO packageAssignment (assignmentID, weddingID, packageID, typeID, assignmentState, progress, price) VALUES (UNHEX(:assignmentID), UNHEX(:weddingID), UNHEX(:packageID), :typeID, :assignmentState, :progress, :price);');
                error_log($typeID . " " . $package['packageID'] . " " . $weddingID . " " . $assignmentID);
                $this->db->bind(':assignmentID', $assignmentID, PDO::PARAM_LOB);
                $this->db->bind(':weddingID', $weddingID, PDO::PARAM_LOB);
                $this->db->bind(':packageID', $package['packageID'], PDO::PARAM_LOB);
                $this->db->bind(':typeID', $typeID, PDO::PARAM_STR);
                $this->db->bind(':assignmentState', 'Unagreed', PDO::PARAM_STR);
                $this->db->bind(':progress', '0', PDO::PARAM_INT);
                $this->db->bind(':price', $package['price'], PDO::PARAM_INT);
                $this->db->execute();
            }
            $this->db->query('UPDATE wedding SET weddingstate = "ongoing" WHERE weddingID = UNHEX(:weddingID);');
            $this->db->bind(':weddingID', $weddingID);
            $this->db->execute();
            $this->db->query('DELETE FROM recommendations WHERE weddingID = UNHEX(:weddingID);');
            $this->db->bind(':weddingID', $weddingID);
            $this->db->execute();
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log($e);
        }
    }

    public function getAssignedPackages($weddingID)
    {
        try {
            $this->db->query('SELECT packageAssignment.*, packages.packageName, packages.fixedCost, vendors.businessName, vendors.imgSrc FROM packageAssignment 
            JOIN packages ON packageAssignment.packageID = packages.packageID 
            JOIN vendors ON packages.vendorID = vendors.vendorID
            WHERE packageAssignment.weddingID = UNHEX(:weddingID);');
            $this->db->bind(':weddingID', $weddingID);
            $this->db->execute();
            $results = $this->db->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $key => $value) {
                $results[$key]['assignmentID'] = bin2hex($value['assignmentID']);
                $results[$key]['packageID'] = bin2hex($value['packageID']);
                unset($results[$key]['weddingID']);
            }
            return $results;
        } catch (PDOException $e) {
            error_log($e);
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function deletePackage($packageID)
    {
        try {
            $this->db->startTransaction();
            $this->db->query("SELECT COUNT(*) AS weddingCount FROM packageassignments JOIN packages ON packageassignments.packageID = packages.packageID WHERE packages.packageID = UNHEX(:packageID);");
            $this->db->bind(":packageID", $packageID, PDO::PARAM_LOB);
            $this->db->execute();
            $state = $this->db->fetch(PDO::FETCH_ASSOC);

            if ($state['weddingCount'] == 0) {
                $this->db->query("DELETE FROM packages WHERE packageID=UNHEX(:packageID);");
                $this->db->bind(":packageID", $packageID, PDO::PARAM_LOB);
                $this->db->execute();

                $this->db->commit();
                return $this->db->rowCount();
            } else {
                $this->db->commit();
                return -1;
            }
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function getPackageDataForPayments($assignmentID)
    {
        try {
            $this->db->query("SELECT p.packageName,p.feature1,p.feature2,p.feature3,p.fixedCost
            FROM packageassignment pa 
            JOIN packages p ON pa.packageID=p.packageID
            WHERE pa.assignmentID=UNHEX(:assignmentID)");
            $this->db->bind(':assignmentID', $assignmentID);
            $this->db->execute();
            $packageDetailsforPayments = [];

            while ($row = $this->db->fetch(PDO::FETCH_ASSOC)) {
                $packageDetailsforPayments[] = $row;
            }

            return $packageDetailsforPayments;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getImageForPackage($packageID){
        try{
            $this->db->query("SELECT path FROM gallery WHERE packageID = UNHEX(:packageID) LIMIT 1");
            $this->db->bind(':packageID', $packageID);
            $this->db->execute();

            $results = $this->db->fetch(PDO::FETCH_ASSOC);
            return $results ? $results['path'] : null;
        }catch(PDOException $e){
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function getAssignedPackagesForPayments($weddingID){
        try{
            $this->db->query("SELECT p.packageName,p.fixedCost FROM packages p
            JOIN packageAssignment pa ON p.packageID = pa.packageID
            WHERE pa.weddingID = UNHEX(:weddingID)");

            $this->db->bind(':weddingID', $weddingID);
            $this->db->execute();

            $results = $this->db->resultSet();
            return $results ? $results : [];


        }catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }
}
