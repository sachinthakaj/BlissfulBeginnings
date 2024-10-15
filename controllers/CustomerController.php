<?php

class CustomerController {
    public function dashboard() {
        require_once '.\views\CustomerWeddingDashboard.php';
    }

    public function fetchData() {
        if (!Authenticate('customer')) {
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