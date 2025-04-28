<?php
// User.php

class Wedding
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance(); // Assuming you have a method to get the PDO instance

    }

    public function fetchDataCustomer($weddingID)
    {
        try {
            $this->db->query("SELECT * from wedding WHERE weddingID = :weddingID");
            $this->db->bind(":weddingID", hex2bin($weddingID), PDO::PARAM_LOB);
            $this->db->execute();
            if ($this->db->rowCount() == 0) {
                error_log("No wedding found");
                throw new Exception("Wedding not found", 1);
            }
            $weddingData = $this->db->fetch(PDO::FETCH_ASSOC);
            $weddingData['weddingID'] = bin2hex($weddingData['weddingID']);
            $weddingData['userID'] = bin2hex($weddingData['userID']);
            $weddingData['weddingTitle'] = $this->getWeddingName($weddingID);
            return $weddingData;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function checkNoWedding($userID)
    {
        try {
            $this->db->query("SELECT * from wedding WHERE userID = :userID");
            $this->db->bind(":userID", hex2bin($userID), PDO::PARAM_STR);
            $this->db->execute();
            if ($this->db->rowCount() == 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log($e);
            throw $e;
        }
    }

    public function getWeddingName($weddingID)
    {
        try {
            $this->db->query("SELECT bridegrooms.* FROM bridegrooms
            JOIN weddingbridegrooms ON bridegrooms.brideGroomsID = weddingbridegrooms.brideID OR bridegrooms.brideGroomsID = weddingbridegrooms.groomID
            WHERE weddingbridegrooms.weddingID = UNHEX(:weddingID)");
            $this->db->bind(":weddingID", $weddingID, PDO::PARAM_STR);
            $this->db->execute();
            $person1 = $this->db->fetch(PDO::FETCH_ASSOC);
            $person2 = $this->db->fetch(PDO::FETCH_ASSOC);
            return $person1['name'] . " & " . $person2['name'];
        } catch (PDOException $e) {
            error_log($e);
            throw $e;
        }
    }

    public function updateWedding($weddingID, $updatedColumns)
    {
        try {
            $this->db->startTransaction();
            $setPart = [];
            $params = [];
            foreach ($updatedColumns["changedWeddingFields"] as $column => $value) {
                $setPart[] = "$column = :$column";
                $params[":$column"] = $value;
            }
            $params[':weddingID'] = hex2bin($weddingID);
            $setPartString = implode(', ', $setPart);
            $sql = "UPDATE wedding SET $setPartString WHERE weddingID = :weddingID";
            error_log($sql);
            $this->db->query($sql);
            $this->db->execute($params);
            if ($updatedColumns["changedBrideFields"]) {
                $this->updatePerson($weddingID, $updatedColumns["changedBrideFields"], "Female");
            }
            if ($updatedColumns["changedGroomFields"]) {
                $this->updatePerson($weddingID, $updatedColumns["changedGroomFields"], "Male");
            }
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            error_log(($e));
            $this->db->rollbackTransaction();
            throw new Exception("Transaction failed: " . $e->getMessage());
        }
    }

    public function updatePerson($weddingID, $updatedColumns, $gender)
    {
        try {

            $setPart = [];
            $params = [];
            foreach ($updatedColumns as $column => $value) {
                $setPart[] = "$column = :$column";
                $params[":$column"] = $value;
            }
            $params[':weddingID'] = hex2bin($weddingID);
            $params[':gender'] = $gender;
            $setPartString = implode(', ', $setPart);
            $sql = "UPDATE brideGrooms 
            JOIN weddingbridegrooms ON bridegrooms.brideGroomsID = weddingbridegrooms.brideID OR bridegrooms.brideGroomsID = weddingbridegrooms.groomID
            SET $setPartString WHERE weddingbridegrooms.weddingID = :weddingID AND bridegrooms.gender=:gender";
            $this->db->query($sql);
            return $this->db->execute($params);;
        } catch (PDOException $e) {
            throw new Exception("Transaction failed: " . $e->getMessage());
        }
    }

    public function fetchDataCouple($weddingID)
    {
        try {
            $this->db->query("SELECT brideGrooms.name, brideGrooms.email, brideGrooms.contact, brideGrooms.address, brideGrooms.gender, brideGrooms.age FROM brideGrooms 
                 JOIN weddingbridegrooms ON bridegrooms.brideGroomsID = weddingbridegrooms.brideID OR bridegrooms.brideGroomsID = weddingbridegrooms.groomID
                 WHERE weddingbridegrooms.weddingID = :weddingID");
            $this->db->bind(":weddingID", hex2bin($weddingID), PDO::PARAM_LOB);
            $this->db->execute();
            $coupleData = $this->db->fetchAll(PDO::FETCH_ASSOC);
            if ($coupleData[0]["gender"] == "Female") {
                $temp = $coupleData[0];
                $coupleData[0] = $coupleData[1];
                $coupleData[1] = $temp;
            }
            $coupleData["brideDetails"] = $coupleData[1];
            unset($coupleData[1]);
            $coupleData["groomDetails"] = $coupleData[0];
            unset($coupleData[0]);
            return $coupleData;
        } catch (PDOException $e) {
            error_log($e);
            echo "Error in the model";
            return false;
        }
    }

    public function createWedding($weddingDetails, $brideDetails, $groomDetails, $userID)
    {
        try {
            $this->db->startTransaction();
            $weddingID =  generateUUID($this->db);
            error_log($weddingID);
            $this->db->query("INSERT INTO wedding (weddingID, userID, date, dayNight, location, theme, sepSalons, sepDressDesigners, weddingstate, weddingPartyMale, weddingPartyFemale, budgetMin, budgetMax)
             VALUES (UNHEX(:weddingID), UNHEX(:userID), :date, :dayNight, :location, :theme,  :sepSalons, :sepDressDesigners, 'new', :weddingPartyMale, :weddingPartyFemale, :budgetMin, :budgetMax)");
            $this->db->bind(':weddingID', $weddingID, PDO::PARAM_LOB);
            $this->db->bind(':userID', $userID);
            $this->db->bind(':date', $weddingDetails['date']);
            $this->db->bind(':dayNight', $weddingDetails['time']);
            $this->db->bind(':location', $weddingDetails['location']);
            $this->db->bind(':theme', $weddingDetails['theme']);
            $this->db->bind(':budgetMin', $weddingDetails['budgetMin']);
            $this->db->bind(':budgetMax', $weddingDetails['budgetMax']);
            $this->db->bind(':sepSalons', $weddingDetails['sepSalons']);
            $this->db->bind(':sepDressDesigners', $weddingDetails['sepDressDesigners']);
            $this->db->bind(':weddingPartyMale', $weddingDetails['weddingPartyMale']);
            $this->db->bind(':weddingPartyFemale', $weddingDetails['weddingPartyFemale']);
            $this->db->execute();


            $brideID = $this->createPerson($brideDetails, "Female", $weddingID);
            $groomID = $this->createPerson($groomDetails, "Male", $weddingID);
            $this->linkWedPersons($weddingID, $brideID, $groomID);
            $this->db->commit();
            return $weddingID;
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            throw new Exception("Transaction failed: " . $e->getMessage());
        }
    }



    private function createPerson($personDetails, $gender)
    {
        $brideGroomsID = generateUUID($this->db);
        $this->db->query("INSERT INTO brideGrooms(brideGroomsID, name, email, contact, address, gender, age) 
        VALUES (UNHEX(:brideGroomsID), :name, :email, :contact, :address, :gender, :age);");
        $this->db->bind(':brideGroomsID', $brideGroomsID, PDO::PARAM_LOB);
        $this->db->bind(':name', $personDetails['name']);
        $this->db->bind(':email', $personDetails['email']);
        $this->db->bind(':contact', $personDetails['contact']);
        $this->db->bind(':address', $personDetails['address']);
        $this->db->bind(':age', $personDetails['age']);
        $this->db->bind(':gender', $gender);
        $this->db->execute();
        return $brideGroomsID;
    }

    private function linkWedPersons($weddingID, $brideID, $groomID)
    {
        $this->db->query("INSERT INTO weddingBrideGrooms VALUES (UNHEX(:weddingID), UNHEX(:brideID), UNHEX(:groomID));");
        $this->db->bind(":weddingID", $weddingID, PDO::PARAM_LOB);
        $this->db->bind(":brideID", $brideID, PDO::PARAM_LOB);
        $this->db->bind(":groomID", $groomID, PDO::PARAM_LOB);
        $this->db->execute();
        return;
    }

    public function getEveryWeddingData()
    {
        try {
            $this->db->query("SELECT w.weddingID,date,theme,location,weddingState,dayNight,b.name AS brideName,g.name AS groomName from wedding w 
            JOIN weddingbridegrooms wbg ON w.weddingID=wbg.weddingID 
            JOIN bridegrooms b ON wbg.brideID = b.brideGroomsID AND b.gender='Female' 
            JOIN bridegrooms g ON wbg.groomID = g.brideGroomsID AND g.gender='Male' 
            ORDER BY FIELD(weddingState, 'new','unassigned','ongoing','finished'), date ASC");
            $this->db->execute();
            $weddings = [];

            while ($row = $this->db->fetch(PDO::FETCH_ASSOC)) {
                $row["weddingID"] = bin2hex($row["weddingID"]);
                $weddings[] = $row;
            }

            return $weddings;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateNewtounassigned($weddingID)
    {
        $this->db->query("UPDATE wedding SET weddingState='unassigned' WHERE weddingID=UNHEX(:weddingID) AND weddingState='new'");
        $this->db->bind(":weddingID", $weddingID, PDO::PARAM_LOB);
        $this->db->execute();
    }

    public function rejectWedding($weddingID, $reason)
    {
        try {
            $this->db->query("UPDATE wedding SET weddingState='rejected', location=:reason WHERE weddingID=UNHEX(:weddingID)");
            $this->db->bind(":weddingID", $weddingID, PDO::PARAM_LOB);
            $this->db->bind(":reason", $reason);
            $this->db->execute();
            return $this->db->rowCount();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteWedding($weddingID)
    {
        try {
            $this->db->startTransaction();
            $this->db->query("SELECT weddingState, userID FROM wedding WHERE weddingID=UNHEX(:weddingID)");
            $this->db->bind(":weddingID", $weddingID, PDO::PARAM_LOB);
            $this->db->execute();
            $state = $this->db->fetch(PDO::FETCH_ASSOC);

            if ($state['weddingState'] != "ongoing") {
                $this->db->query("DELETE FROM wedding WHERE weddingID=UNHEX(:weddingID)");
                $this->db->bind(":weddingID", $weddingID, PDO::PARAM_LOB);
                $this->db->execute();

                $this->db->query("DELETE FROM users WHERE userID=UNHEX(:userID)");
                $this->db->bind(":userID", bin2hex($state['userID']), PDO::PARAM_LOB);
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


    public function getSerchedWeddingData($str1, $str2)
    {
        try {
            $this->db->query("SELECT w.weddingID,date,theme,location,weddingState,dayNight,b.name AS brideName,g.name AS groomName from wedding w 
            JOIN weddingbridegrooms wbg ON w.weddingID=wbg.weddingID 
            JOIN bridegrooms b ON wbg.brideID = b.brideGroomsID AND b.gender='Female' 
            JOIN bridegrooms g ON wbg.groomID = g.brideGroomsID AND g.gender='Male'
            WHERE LOWER(b.name) LIKE :str1 OR LOWER(g.name) LIKE :str2 OR LOWER(g.name) LIKE :str1 OR LOWER(b.name) LIKE :str2
            ORDER BY FIELD(weddingState, 'new','unassigned','ongoing','finished'), date ASC");

            $this->db->bind(':str1', '%' . strtolower($str1) . '%', PDO::PARAM_STR);
            $this->db->bind(':str2', '%' . strtolower($str2) . '%', PDO::PARAM_STR);
            $this->db->execute();
            $weddings = [];

            while ($row = $this->db->fetch(PDO::FETCH_ASSOC)) {
                $row["weddingID"] = bin2hex($row["weddingID"]);
                $weddings[] = $row;
            }

            return $weddings;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getRatings($weddingID)
    {
        try {
            $this->db->query("SELECT a.assignmentID, a.typeID, a.ratings, v.businessName FROM packageAssignments a INNER JOIN packages p ON a.packageID = p.packageID 
            INNER JOIN vendors v ON v.vendorID = p.vendorID WHERE weddingID=UNHEX(:weddingID)");
            $this->db->bind(":weddingID", $weddingID, PDO::PARAM_LOB);
            $this->db->execute();
            $result = $this->db->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function rateVendor($assignmentID, $rating)
    {
        try {
            $this->db->query("UPDATE packageAssignment SET rating=:rating WHERE assignmentID=UNHEX(:assignmentID)");
            $this->db->bind(":rating", $rating, PDO::PARAM_INT);
            $this->db->bind(":assignmentID", $assignmentID, PDO::PARAM_LOB);
            $this->db->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }
    public function getWeddingDate($weddingID)
    {
        try {
            $this->db->query("SELECT date from wedding WHERE weddingID=UNHEX(:weddingID)");
            $this->db->bind(":weddingID", $weddingID);
            $this->db->execute();
            $result = $this->db->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
