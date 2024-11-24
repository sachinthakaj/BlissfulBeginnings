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



    public function fetchData($weddingID)
    {
        if (!Authenticate('customer', $weddingID)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $wedding = new Wedding();
            $weddingDetails = $wedding->fetchDataCustomer($weddingID['weddingID']);
            if ($weddingDetails) {
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
            $package->setPackages($parameters['weddingID'], $parsed_data);


        } catch(PDOException $e) {
            error_log($e);
        }
    }

    
}
