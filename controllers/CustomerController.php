<?php

class CustomerController
{
    public function dashboard()
    {
        require_once '.\public\CustomerWeddingDashboard.php';
    }
    public function resetPassword()
    {
        require_once './public/resetPassword.html';
    }

    public function makePayments()
    {
        require_once './public/customerWeddingPayments.php';
    }


    public function validateUserID($parameters)
    {
        if (! Authenticate('customer', $parameters['userID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        };
        $customer = new Wedding();
        $result = $customer->checkNoWedding($parameters['userID']);
        if ($result) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(['message' => '']);
        } else {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'User already has a wedding.']);
        }
    }

    public function fetchData($parameters)
    {
        if (!(Authenticate('planner', '123') || Authenticate('customer', $parameters['weddingID']))) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $wedding = new Wedding();
            $weddingDetails = $wedding->fetchDataCustomer($parameters['weddingID']);
            error_log(json_encode($weddingDetails));
            if ($weddingDetails) {
                unset($weddingDetails['userID']);
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($weddingDetails);
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid UserID']);
            }
        } catch (Exception) {
        }
    }

    public function fetchPersons($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authorization failed']);
        }
        try {
            $wedding = new Wedding();
            $coupleDetails = $wedding->fetchDataCouple($parameters['weddingID']);
            if ($coupleDetails) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($coupleDetails, JSON_PRETTY_PRINT);
            } else {
                header('HTTP/1.1 404 NOT FOUND');
                echo json_encode(['error' => 'Invalid UserID']);
            }
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function packages($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $package = new Package();
            $packageDetails = $package->fetchWeddingPackages($parameters['weddingID']);
            if ($packageDetails) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($packageDetails);
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid UserID']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching data']);
        }
    }

    public function getReccomendations($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $package = new Package();
            $recommendations = $package->fetchRecommendations($parameters['weddingID']);
            if ($recommendations) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($recommendations);
            } else {
                header('HTTP/1.1 404 Resource Not Found');
                echo json_encode(['error' => 'Resource not Found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching data']);
        }
    }

    public function setPackages($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $package = new Package();
            if ($package->setPackages($parameters['weddingID'], $parsed_data)) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['message' => 'Packages set successfully']);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'Error setting packages']);
            }
        } catch (PDOException $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error setting packages']);
        }
    }

    public function getAssignedPackages($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'You need to be logged in']);
            return;
        }
        try {
            $package = new Package();
            $assignedPackages = $package->getAssignedPackages($parameters['weddingID']);
            if ($assignedPackages) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($assignedPackages);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting assigned packages']);
        }
    }


    public function deleteWedding($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
        }
        try {
            $wedding = new Wedding();
            $result = $wedding->deleteWedding($parameters['weddingID']);
            if ($result > 0) {
                header('HTTP/1.1 200 okay');
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['message' => "Wedding Deleted successfully"]);
            } else if ($result == 0) {
                header("HTTP/1.1 204 No Content");
                echo json_encode(['error' => 'Wedding not found']);
            } else {
                header('HTTP/1.1 409 Conflict');
                echo json_encode(['error' => 'Wedding is currently ongoing']);
            }
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function getAmountToPayCustomer($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
            exit();
        }
        try {
            $payment = new Payment();

            $amount = $payment->getAmountToPayCustomer($parameters['weddingID']);

            if ($amount) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($amount);
            } else {
                header('HTTP/1.1 404 Resource Not Found');
                echo json_encode(['error' => 'Resource not found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting amount to pay']);
        }
    }

    public function getAssignedPackagesForPayments($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
            exit();
        }
        try {
            $package = new Package();
            $packageNames = $package->getAssignedPackagesForPayments($parameters['weddingID']);

            if ($packageNames) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($packageNames);
            } else {
                header('HTTP/1.1 404 Resource Not Found');
                echo json_encode(['error' => 'Resource not found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting assigned packages for payments']);
        }
    }


    public function addCustomerPaymentDetails($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
            exit();
        }

        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);

            $weddingID = $parsed_data['weddingID'];
            $amount = $parsed_data['amount'];
            $currency = $parsed_data['currency'];
            $statusCode = $parsed_data['statusCode'];

            $payment = new Payment();
            $orderID = $payment->createOrderIdForPaymentGateway();
            $result = $payment->addCustomerPaymentDetails($weddingID, $orderID, $amount, $currency, $statusCode);

            if ($result === true) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['message' => 'Payment added successfully']);
            } else {
                header('HTTP/1.1 409 Conflict');
                echo json_encode(['error' => 'Ongoing payment exists']);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error adding payment']);
        }
    }

    public function getOngoingPayments($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
            exit();
        }
        try {
            $payment = new Payment();
            $result = $payment->getOngoingPayments($parameters['weddingID']);
            if ($result) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($result);
            } else {
                header('HTTP/1.1 404 Resource Not Found');
                echo json_encode(['error' => 'Resource not found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting ongoing payments']);
        }
    }

    public function deleteOngoingPayments($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
            exit();
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $paymentID = $parsed_data['paymentID'];
            $payment = new Payment();
            $result = $payment->deleteOngoingPayments($paymentID);
            if ($result) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['message' => 'Payment deleted successfully']);
            } else {
                header('HTTP/1.1 404 Resource Not Found');
                echo json_encode(['error' => 'Resource not found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error deleting payment']);
        }
    }


    public function generateHashForPaymentGateway($parameters)
    {


        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
            exit();
        }
        try {

            $payment = new Payment();
            $result = $payment->getOngoingPayments($parameters['weddingID']);
            $order_id = $result->orderID;
            $payment_id = $result->paymentID;
            $merchant_id = "1228991";
            $merchant_secret = $_ENV['PAYHERE_SECRET'];
            $currency = "LKR";
            $amount = $result->amount;


            $hash = strtoupper(
                md5(
                    $merchant_id .
                        $order_id .
                        number_format($amount, 2, '.', '') .
                        $currency .
                        strtoupper(md5($merchant_secret))
                )


            );



            if ($hash) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['paymentID'=>$payment_id,'orderID' => $order_id, 'hash' => $hash, 'amount' => $amount]);
            } else {
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'Hash ccould not create']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }


    public function getPaymentData()
    {


        try {
            $merchant_id         = $_POST['merchant_id'];
            $payment_id          = $_POST['custom_1'];
            $wedding_id          = $_POST['custom_2'];
            $order_id            = $_POST['order_id'];
            $payhere_amount      = $_POST['payhere_amount'];
            $payhere_currency    = $_POST['payhere_currency'];
            $status_code         = $_POST['status_code'];
            $md5sig              = $_POST['md5sig'];

            $merchant_secret = $_ENV['PAYHERE_SECRET']; // Replace with your Merchant Secret

            $local_md5sig = strtoupper(
                md5(
                    $merchant_id .
                        $order_id .
                        $payhere_amount .
                        $payhere_currency .
                        $status_code .
                        strtoupper(md5($merchant_secret))
                )
            );

            if (($local_md5sig === $md5sig) and ($status_code === "2")) {
                $payment = new Payment();
                $result = $payment->addFinalCustomerPaymentData($wedding_id,$payment_id, $order_id, $payhere_amount, $payhere_currency, $status_code);
                if ($result == true) {
                    header('Content-Type:application/json');
                    echo json_encode(["status" => "success", "message" => "Payment Successfully Recorded"]);
                } else {
                    header('Content-Type:application/json');
                    echo json_encode(["status" => "failed", "message" => "Payment Failed to  Record"]);
                }
            } else {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Invalid Payment Details or Signature']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getTasksDetailsForWeddingProgress($parameters){
        if(!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
            exit;
        };
        try{
            if(!isset($parameters['weddingID']) || empty($parameters['weddingID'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Wedding ID is required']);
                return;
            }

            $task = new Task();
            $tasks = $task->getAllTasksForAWedding($parameters['weddingID']);

            if (!empty($tasks)) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['status' => 'success', 'tasks' => $tasks]);
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(['error' => 'No tasks found for the specified wedding']);
            }

        } catch (Exception $e){
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting tasks details']);
        }

    }



    public function getRatings($parameters)
    {
        try {
            $weddingID = $parameters['weddingID'];
            $wedding = new Wedding();
            $result = $wedding->getRatings($weddingID);
            if ($result) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($result);
            } else {
                header('HTTP/1.1 404 Resource Not Found');
                echo json_encode(['error' => 'Resource not found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }   
    
    public function rateVendor($parameters) {
        if (!Authenticate('customer', $parameters['assignmentID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authentication failed']);
            exit();
        }
        try {
            $assignmentID = $parameters['assignmentID'];    
            $wedding = new Wedding();
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $result = $wedding->rateVendor($assignmentID, $parsed_data['rating']);
            if ($result) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['message' => 'Rating added successfully']);
            } else {
                header('HTTP/1.1 404 Resource Not Found');
                echo json_encode(['error' => 'Resource not found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
            
    }
}
