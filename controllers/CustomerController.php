<?php

class CustomerController {
    public function dashboard() {
        require_once '.\public\CustomerWeddingDashboard.php';
    }

    public function fetchData($weddingID) {
        if (!Authenticate('customer', $weddingID)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $wedding = new Wedding();
            $weddingDetails = $wedding->fetchDataCustomer($weddingID['weddingID']);
            if($weddingDetails) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($weddingDetails);
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid UserID']);
            }
            
        } catch(Exception) {
            
        }
    }

    public function fetchPersons($parameters) {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authorization failed']);
        }
        try {
            $wedding = new Wedding();
            $coupleDetails = $wedding->fetchDataCouple($parameters['weddingID']);
            if($coupleDetails) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($coupleDetails, JSON_PRETTY_PRINT);
            } else {
                header('HTTP/1.1 404 NOT FOUND');
                echo json_encode(['error' => 'Invalid UserID']);
            }
            
        } catch(Exception $e) {
            error_log($e);
        }
    }

    public function packages($parameters) {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $package = new Package();
            $packageDetails = $package->fetchWeddingPackages($parameters['weddingID']);
            if($packageDetails) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($packageDetails);
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid UserID']);
            }
            
        } catch(Exception) {
            
        }
    }
}