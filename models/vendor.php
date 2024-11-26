<?php

class Vendor
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function emailExists($email)
    {
        $this->db->query('SELECT COUNT(*) FROM vendors WHERE email = :email');
        $this->db->bind(':email', $email, PDO::PARAM_STR);
        $this->db->execute();
        return $this->db->fetchColumn() > 0;
    }


    public function createVendor($email, $password, $businessName, $type, $contact, $address, $description, $websiteLink)
    {
        try {
            $this->db->startTransaction();
            $UUID = generateUUID($this->db);
            $this->db->query("INSERT INTO vendors (vendorID,email,password,businessName,typeID,contact,address, description, vendorstate, websiteLink) VALUES (UNHEX(:uuid),:email,:password,:businessName,:type,:contact,:address,:description, :vendorstate, :websiteLink);");
            $this->db->bind(':uuid', $UUID, PDO::PARAM_LOB);
            $this->db->bind(':email', $email, PDO::PARAM_STR);
            $this->db->bind(':password', $password, PDO::PARAM_STR);
            $this->db->bind(':businessName', $businessName, PDO::PARAM_STR);
            $this->db->bind(':type', $type, PDO::PARAM_STR);
            $this->db->bind(':contact', $contact, PDO::PARAM_STR);
            $this->db->bind(':address', $address, PDO::PARAM_STR);
            $this->db->bind(':description', $description, PDO::PARAM_STR);
            $this->db->bind(':websiteLink', $websiteLink, PDO::PARAM_STR);
            $this->db->bind(':vendorstate', 'new', PDO::PARAM_STR);
            $numRows = $this->db->execute();
            $notificationID = generateUUID($this->db);
            $this->db->query('INSERT INTO newvendornotifications VALUES (UNHEX(:notificationID), :title, :message, UNHEX(:reference))');
            $this->db->bind(':notificationID', $notificationID, PDO::PARAM_LOB);
            $this->db->bind(':title', 'New Vendor', PDO::PARAM_STR);
            $this->db->bind(':message', 'A new vendor has been added to the system.', PDO::PARAM_STR);
            $this->db->bind(':reference', $UUID, PDO::PARAM_LOB);
            $this->db->execute();
            $this->db->commit();
            error_log("numrows: $numRows");
            if ($numRows == 1) {
                return $UUID;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            error_log($e);
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function getVendorByEmail($email)
    {
        $this->db->query('SELECT * FROM vendors WHERE email= :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
        $result = $this->db->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getSalons()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Salon"');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPhotographers()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="photographer"');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDdesigners()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Dress Designer"');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getFlorists()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName FROM vendors WHERE typeID="Florist"');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWeddings($vendorID)
    {
        $this->db->query('SELECT wedding.* FROM wedding INNER JOIN packageassignment 
                        ON wedding.weddingID=packageassignment.weddingID INNER JOIN packages 
                        ON packageassignment.packageID=packages.packageID INNER JOIN vendors 
                        ON packages.vendorID=vendors.vendorID WHERE vendors.vendorID=UNHEX(:vendorID)');
        $this->db->bind(':vendorID', $vendorID);
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllVendorsForWedding($weddingID)
    {
        try {
            $this->db->query("SELECT v.vendorID,v.businessName,v.typeID
        FROM vendors v
        JOIN packages p ON v.vendorID=p.vendorID
        JOIN packageAssignment pa ON p.packageID=pa.packageID
        WHERE pa.weddingID=UNHEX(:weddingID)");

            $this->db->bind(":weddingID", $weddingID, PDO::PARAM_LOB);
            $this->db->execute();
            $vendors = [];
            while ($row = $this->db->fetch(PDO::FETCH_ASSOC)) {
                $row["vendorID"] = bin2hex($row["vendorID"]);
                $vendors[] = $row;
            }

            return $vendors;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getVendorDetailsAndPackages($vendorID)
    {
        
        $this->db->query("SELECT * FROM vendors where vendorID = UNHEX(:vendorID);");
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $this->db->execute();
        $vendorDetails = $this->db->fetch(PDO::FETCH_ASSOC);
        if ($vendorDetails) {
            $vendorDetails['vendorID'] = bin2hex($vendorDetails['vendorID']);
            $package = new Package();
            $packageDetails = $package->getPackages($vendorID, $vendorDetails['typeID']);
            $vendorDetails['packages'] = $packageDetails;
            return $vendorDetails;
        } else {
            throw new Exception("Empty Set returned", 1);
        }
    }
    public function getProfileDetails($vendorID)
    {
        
        try {
            $this->db->query("SELECT * FROM vendors where vendorID = UNHEX(:vendorID);");
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->execute();
            $vendorDetails = $this->db->fetch(PDO::FETCH_ASSOC);
            unset($vendorDetails['password']);
            return $vendorDetails;
        } catch (Exception $e) {
            error_log($e);
            throw new Exception("Error Processing Request", 1);
        }
    }

    public function updateProfileDetails($vendorID, $updatedColumns)
    {
        try {

            $setPart = [];
            $params = [];
            foreach ($updatedColumns as $column => $value) {
                $setPart[] = "$column = :$column";
                $params[":$column"] = $value;
            }
            $params[':vendorID'] = hex2bin($vendorID);
            $setPartString = implode(', ', $setPart);
            $sql = "UPDATE vendors SET $setPartString WHERE vendorID = :vendorID";
            error_log($sql);
            $this->db->query($sql);
            $this->db->execute($params);
            return $this->db->rowCount();
        } catch (Exception $e) {
            error_log($e);
            throw new Exception("Error Processing Request", 1);
        }
    }
    public function deleteProfile($vendorID)
    {
        try {
            $this->db->query('SELECT COUNT(*) as numweddings FROM packageassignment  INNER JOIN packages ON packageassignment.packageID = packages.packageID INNER JOIN vendors ON packages.vendorID = vendors.vendorID WHERE vendors.vendorID = UNHEX(:vendorID)');
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->execute();
            $result = $this->db->fetch(PDO::FETCH_ASSOC);
            if ($result['numweddings'] == 0) {
                $this->db->query("DELETE FROM vendors WHERE vendorID = UNHEX(:vendorID);");
                $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
                $this->db->execute();
                return $this->db->rowCount();
            } else {
                return -1;
            }
        } catch (Exception $e) {
            error_log($e);
            throw new Exception("Error Processing Request", 1);
        }
    }
}
