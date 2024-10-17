<?php

class CustomerController {
    public function dashboard() {
        require_once '.\public\CustomerWeddingDashboard.php';
    }

    public function fetchData($weddingID) {
        if (!Authenticate('customer', $weddingID)) {
            header('HTTP/1.1 401 Internal Server Error');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $wedding = new Wedding();
            if($weddingDetails = $wedding->fetchDataCustomer($weddingID['weddingID'])) {
                // error_log(json_encode($weddingDetails));
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($weddingDetails);
            } else {
                header('HTTP/1.1 401 FORBIDDEN');
                echo json_encode(['error' => 'Invalid UserID']);
            }
            
        } catch(Exception) {
            
        }
    }
}