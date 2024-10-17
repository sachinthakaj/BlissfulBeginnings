<?php

class CustomerController {
    public function dashboard() {
        require_once '.\public\CustomerWeddingDashboard.php';
    }

    public function fetchData($weddingID) {
        if (!Authenticate('customer', $ID)) {
            header('HTTP/1.1 401 Internal Server Error');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $data = file_get_contents('php://input');
            // Decode the JSON into a PHP associative array
            $parsed_data = json_decode($data, true);
            $weddingID = $parsed_data['weddingID'];
            $wedding = new Wedding();
            $weddingDetails = $wedding.fetchDataCustomer($weddingID);
        } catch(Exception) {
            
        }
    }
}