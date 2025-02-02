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

    public function validateUserID($parameters){
        if(! Authenticate('customer', $parameters['userID'])){
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        };
        $customer = new Wedding();
        $result = $customer->checkNoWedding($parameters['userID']);
        if($result) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(['message' => '']);
        } else {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'User already has a wedding.']);

        }
    }

    public function fetchData($parameters)
    {
        if (!(Authenticate('planner', '123') ||Authenticate('customer', $parameters['weddingID']))) {
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

        } catch (Exception $e ) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching data']);
        }
      
    }

    public function setPackages($parameters) {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $package = new Package();
            if($package->setPackages($parameters['weddingID'], $parsed_data)){
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['message' => 'Packages set successfully']);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'Error setting packages']);
            }


        } catch(PDOException $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error setting packages']);
        }
    }

    public function getAssignedPackages($parameters) {
        if(!Authenticate('customer', $parameters['weddingID'])){
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'You need to be logged in']);
            return;
        } 
        try {
            $package = new Package();
            $assignedPackages = $package->getAssignedPackages($parameters['weddingID']);
            if($assignedPackages) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($assignedPackages);
            }

        }catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting assigned packages']);
        }
    }


    public function deleteWedding($parameters) {
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
                echo json_encode(['message'=> "Wedding Deleted successfully"]);
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

    
}
