<?php

class Vendor
{
    private $db;
    private $images = ["Photographer" => '/public/assets/images/photographer.png', "Salon" => '/public/assets/images/salon.png', "Florist" => '/public/assets/images/florist.png', "Dress Designer" => '/public/assets/images/dressDesigner.png'];

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

    public function createProfilePhoto($vendorID, $relativePath) {
        $this->db->query('UPDATE vendors SET imgSrc = :path WHERE vendorID = UNHEX(:vendorID)');
        $this->db->bind(':path', $relativePath);
        $this->db->bind(':vendorID', $vendorID);
        return $this->db->execute();
    }   

    public function createVendor($email, $password, $businessName, $type, $contact, $address, $description, $websiteLink)
    {
        try {
            $imageLink = '/random-images/' . dechex(rand(0, 15)) . '.jpg';
            error_log($imageLink);
            $this->db->startTransaction();
            $UUID = generateUUID($this->db);
            // $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cdn' . DIRECTORY_SEPARATOR . 'profilePhotos';
            // if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            //     http_response_code(500);
            //     echo json_encode(["error" => "Failed to create directory"]);
            //     return;
            // }
            // $file = $_FILES['image'] ?? null;
            // $filename = 'img_' . $UUID . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            // $path = $uploadDir . DIRECTORY_SEPARATOR . $filename;
            $this->db->query("INSERT INTO vendors (vendorID,email,password,businessName,typeID,contact,address, description, vendorstate,imgSrc, websiteLink) VALUES (UNHEX(:uuid),:email,:password,:businessName,:type,:contact,:address,:description, :vendorstate,:imgSrc, :websiteLink);");
            $this->db->bind(':uuid', $UUID, PDO::PARAM_LOB);
            $this->db->bind(':email', $email, PDO::PARAM_STR);
            $this->db->bind(':password', $password, PDO::PARAM_STR);
            // $this->db->bind(':path', $path, PDO::PARAM_STR);
            $this->db->bind(':businessName', $businessName, PDO::PARAM_STR);
            $this->db->bind(':type', $type, PDO::PARAM_STR);
            $this->db->bind(':contact', $contact, PDO::PARAM_STR);
            $this->db->bind(':address', $address, PDO::PARAM_STR);
            $this->db->bind(':description', $description, PDO::PARAM_STR);
            $this->db->bind(':websiteLink', $websiteLink, PDO::PARAM_STR);
            $this->db->bind(':imgSrc', $imageLink, PDO::PARAM_STR);
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
        $this->db->query('SELECT vendorID,description,typeID,businessName, rating, imgSrc FROM vendors WHERE typeID="Salon" AND vendorstate="accepted"');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPhotographers()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName, rating, imgSrc FROM vendors WHERE typeID="photographer" AND vendorstate="accepted"');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDdesigners()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName, rating, imgSrc FROM vendors WHERE typeID="Dress Designer" AND vendorstate="accepted"');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getFlorists()
    {
        $this->db->query('SELECT vendorID,description,typeID,businessName, rating, imgSrc FROM vendors WHERE typeID="Florist" AND vendorstate="accepted"');
        $this->db->execute();
        return $this->db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWeddings($vendorID)
    {
        try {
            $this->db->query('SELECT wedding.*, packageassignment.assignmentID as assignmentID FROM wedding INNER JOIN packageassignment 
                            ON wedding.weddingID=packageassignment.weddingID INNER JOIN packages 
                            ON packageassignment.packageID=packages.packageID INNER JOIN vendors 
                            ON packages.vendorID=vendors.vendorID WHERE vendors.vendorID=UNHEX(:vendorID)');
            $this->db->bind(':vendorID', $vendorID);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            $customer = new Wedding();
            foreach ($result as $index => $value) {
                $result[$index]['weddingTitle'] = $customer->getWeddingName(bin2hex($value['weddingID']));
                $result[$index]['progress'] = $this->getAssignmentProgress(bin2hex($value['assignmentID']));
            }
            $this->db->query("SELECT businessName, vendorState from vendors WHERE vendorID=UNHEX(:vendorID)");
            $this->db->bind(':vendorID', $vendorID);
            $this->db->execute();
            $vendor = $this->db->fetch(PDO::FETCH_ASSOC);
            $vendor["weddings"] = $result;
            return $vendor;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAssignmentProgress($assignmentID) {
        try {
            $this->db->query("SELECT state, COUNT(*) AS taskCount FROM task t
            WHERE assignmentID=UNHEX(:assignmentID) GROUP BY state;");
            $this->db->bind(':assignmentID', $assignmentID);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            if(isset($result[1]) && $result[1]["taskCount"] > 0) {
                return $result[1]["taskCount"] / ($result[1]["taskCount"] + $result[0]["taskCount"]) * 100;
                
            } else {
                return 0;
            }
            // var_dump($result);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function getAssignedVendors($weddingID)
    {   
        try {
            $this->db->query("SELECT v.vendorID,v.businessName,pa.typeID, pa.assignmentID ,pa.isPaid
        FROM vendors v
        JOIN packages p ON v.vendorID=p.vendorID
        JOIN packageassignment pa ON p.packageID=pa.packageID
        WHERE pa.weddingID=UNHEX(:weddingID)");

            $this->db->bind(":weddingID", $weddingID, PDO::PARAM_STR);
            error_log("There");
            $this->db->execute();
            $vendors = [];
            error_log($this->db->rowCount());
            while ($row = $this->db->fetch(PDO::FETCH_ASSOC)) {
                $row["vendorID"] = bin2hex($row["vendorID"]);
                $row["assignmentID"] = bin2hex($row["assignmentID"]);
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

    public function getWeddingIDbyAssignmentID($assignmentID) {
        try{
            $this->db->query('SELECT weddingID, v.businessName FROM packageassignment
            JOIN Packages p ON p.packageID = packageAssignment.packageID 
            JOIN Vendors v ON p.vendorID = v.vendorID 
            WHERE assignmentID = UNHEX(:assignmentID);');
            $this->db->bind(':assignmentID', $assignmentID, PDO::PARAM_STR);
            $this->db->execute();
            $result = $this->db->single();
            $result->weddingID   = bin2hex($result->weddingID);
            return $result;
        } catch( Exception $e) {
            error_log($e);
            throw $e;
        }
    }

    public function deleteVendor($vendorID) {
    try {

        // Check for assigned weddings
        $this->db->query('SELECT COUNT(*) as numweddings FROM packageassignment 
                         INNER JOIN packages ON packageassignment.packageID = packages.packageID 
                         INNER JOIN vendors ON packages.vendorID = vendors.vendorID 
                         WHERE vendors.vendorID = UNHEX(:vendorID)');
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $this->db->execute();
        $result = $this->db->fetch(PDO::FETCH_ASSOC);

        if ($result['numweddings'] > 0) {
            return -1; // Vendor has weddings
        }

        // Proceed with deletion
        $this->db->query("DELETE FROM vendors WHERE vendorID = UNHEX(:vendorID)");
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $this->db->execute();

        // Verify deletion
        $this->db->query('SELECT 1 FROM vendors WHERE vendorID = UNHEX(:vendorID)');
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $this->db->execute();
        
        return $this->db->rowCount() === 0 ? 1 : 0;
    } catch (Exception $e) {
        error_log('Delete Vendor Error: ' . $e->getMessage());
        throw new Exception("Database operation failed");
    }
}

}
