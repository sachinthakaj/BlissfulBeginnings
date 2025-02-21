<?php

class Payment
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createOrderIdForPaymentGateway()
    {
        $orderID =  generateUUID($this->db);
        return  bin2hex($orderID);
    }



    public function addPayment($assignment_id, $order_id, $payhere_amount, $payhere_currency, $status_code)
    {
        try {
            $paymentID = generateUUID($this->db);
            $this->db->query("INSERT INTO plannerpayment(paymentID,assignmentID,orderID,payhereAmount,payhereCurrency,statusCode)
            VALUES (UNHEX(:paymentID),UNHEX(:assignmentID),UNHEX(:orderID),:payhereAmount,:payhereCurrency,:statusCode);");

            $this->db->bind(':paymentID', $paymentID);
            $this->db->bind(':assignmentID', $assignment_id);
            $this->db->bind(':orderID', $order_id);
            $this->db->bind(':payhereAmount', $payhere_amount);
            $this->db->bind(':payhereCurrency', $payhere_currency);
            $this->db->bind(':statusCode', $status_code);

            $this->db->execute();

            $this->db->query("UPDATE packageAssignment SET isPaid=TRUE WHERE assignmentID=UNHEX(:assignmentID)");
            $this->db->bind(':assignmentID', $assignment_id);
            $this->db->execute();


            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAmountToPayCustomer($wedding_ID)
    {
        try {
            $this->db->query("SELECT SUM(p.fixedCost) as totalPackagesValue,w.currentPaid
            FROM packageAssignment pa 
            JOIN wedding w ON pa.weddingID=w.weddingID
            JOIN packages p ON pa.packageID=p.packageID
            WHERE pa.weddingID=UNHEX(:wedding_ID)
            GROUP BY pa.weddingID;");

            $this->db->bind(':wedding_ID', $wedding_ID);
            $result = $this->db->single();
            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

   
    
    public function addCustomerPaymentDetails($weddingID, $orderID, $amount, $currency, $statusCode) {
        try {
            $this->db->startTransaction();
    
            // Check for existing ongoing payments
            $this->db->query("SELECT COUNT(*) as count FROM customerPayment 
                             WHERE weddingID = UNHEX(:weddingID) AND statusCode = '0';");
            $this->db->bind(':weddingID', $weddingID);
            $result = $this->db->single();
    
            if ($result->count > 0) {
                $this->db->rollbackTransaction();
                return false; // Existing ongoing payment found
            }
    
            // Proceed with insert if no ongoing payments
            $paymentID = generateUUID($this->db);
            $this->db->query("INSERT INTO customerPayment(paymentID,weddingID,orderID,amount,currency,statusCode) 
                             VALUES (UNHEX(:paymentID),UNHEX(:weddingID),UNHEX(:orderID),:amount,:currency,:statusCode);");
            
            $this->db->bind(':paymentID', $paymentID);
            $this->db->bind(':weddingID', $weddingID);
            $this->db->bind(':orderID', $orderID);
            $this->db->bind(':amount', $amount);
            $this->db->bind(':currency', $currency);
            $this->db->bind(':statusCode', $statusCode);
            
            $this->db->execute();
            $this->db->commit();
            
            return true;
    
        } catch(PDOException $e) {
            $this->db->rollbackTransaction();
            error_log($e->getMessage());
            return false;
        }
    }

public function getOngoingPayments($weddingID){
    try{
        $this->db->query("SELECT amount,paymentID,orderID FROM customerPayment WHERE weddingID=UNHEX(:weddingID) AND statusCode='0';");
        $this->db->bind(':weddingID', $weddingID);
        $result = $this->db->single();
        $result->paymentID = bin2hex($result->paymentID);
        $result->orderID = bin2hex($result->orderID);
        return $result;
    }catch(PDOException $e){
        error_log($e->getMessage());
        return false;
    }
}

public function deleteOngoingPayments($paymentID){
    try{
        $this->db->query("DELETE FROM customerPayment WHERE paymentID=UNHEX(:paymentID) AND statusCode='0';");
        $this->db->bind(':paymentID', $paymentID);
        $this->db->execute();
        return true;
    }catch(PDOException $e){
        error_log($e->getMessage());
        return false;
    }


}

public function addFinalCustomerPaymentData($wedding_id,$payment_id, $order_id, $payhere_amount, $payhere_currency, $status_code){
    try{
        $this->db->query("UPDATE customerPayment SET orderID=UNHEX(:orderID),amount=:payhereAmount,currency=:payhereCurrency,statusCode=:statusCode WHERE paymentID=UNHEX(:paymentID);");
        $this->db->bind(':paymentID',$payment_id);
        $this->db->bind(':orderID',$order_id);
        $this->db->bind(':payhereAmount',$payhere_amount);
        $this->db->bind(':payhereCurrency',$payhere_currency);
        $this->db->bind(':statusCode',$status_code);
        $this->db->execute();

        $this->db->query("UPDATE wedding SET currentPaid=currentPaid + (:payhereAmount) WHERE weddingID=UNHEX(:weddingID);");
        $this->db->bind(':weddingID',$wedding_id);
        $this->db->bind(':payhereAmount',$payhere_amount);
        $this->db->execute();

        return true;


    }catch(PDOException $e){
        error_log($e->getMessage());
        return false;
    }


}
}
