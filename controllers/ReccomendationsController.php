<?php


class ReccomendationsController
{
    public function __construct() {}

    public function getSalonReccomendations($parameters) {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $reccomendations = new Reccomendations();
            $brideSalonList = $reccomendations->getSalonReccomendations($budget);
            if(empty($brideSalonList)){
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No Salons Found']);
            }
            for ($i = 0; $i < count($brideSalonList); $i++) {
                $brideSalonList[$i]['packageID'] = bin2hex($brideSalonList[$i]['packageID']);
                $brideSalonList[$i]['vendorID'] = bin2hex($brideSalonList[$i]['vendorID']);
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($brideSalonList);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getBrideSalonReccomendations($parameters)
    {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $reccomendations = new Reccomendations();
            $brideSalonList = $reccomendations->getBrideSalonReccomendations($budget);
            if(empty($brideSalonList)){
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No Bride Salons Found']);
            }
            for ($i = 0; $i < count($brideSalonList); $i++) {
                $brideSalonList[$i]['packageID'] = bin2hex($brideSalonList[$i]['packageID']);
                $brideSalonList[$i]['vendorID'] = bin2hex($brideSalonList[$i]['vendorID']);
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($brideSalonList);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getGroomSalonReccomendations($parameters) {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $reccomendations = new Reccomendations();
            $brideSalonList = $reccomendations->getGroomSalonReccomendations($budget);
            if(empty($brideSalonList)){
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No Groom Salons Found']);
            }
            for ($i = 0; $i < count($brideSalonList); $i++) {
                $brideSalonList[$i]['packageID'] = bin2hex($brideSalonList[$i]['packageID']);
                $brideSalonList[$i]['vendorID'] = bin2hex($brideSalonList[$i]['vendorID']);
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($brideSalonList);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getPhotographerReccomendations($parameters) {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $reccomendations = new Reccomendations();
            $brideSalonList = $reccomendations->getPhotographerReccomendations($budget);
            if(empty($brideSalonList)){
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No Photographers Found']);
            }
            for ($i = 0; $i < count($brideSalonList); $i++) {
                $brideSalonList[$i]['packageID'] = bin2hex($brideSalonList[$i]['packageID']);
                $brideSalonList[$i]['vendorID'] = bin2hex($brideSalonList[$i]['vendorID']);
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($brideSalonList);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getDressDesignerReccomendations($parameters) {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $reccomendations = new Reccomendations();
            $brideSalonList = $reccomendations->getDressDesignerReccomendations($budget);
            if(empty($brideSalonList)){
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No Dress Designers Found']);
            }
            for ($i = 0; $i < count($brideSalonList); $i++) {
                $brideSalonList[$i]['packageID'] = bin2hex($brideSalonList[$i]['packageID']);
                $brideSalonList[$i]['vendorID'] = bin2hex($brideSalonList[$i]['vendorID']);
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($brideSalonList);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getBrideDressDesignerReccomendations($parameters) {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $reccomendations = new Reccomendations();
            $brideSalonList = $reccomendations->getBrideDressDesignerReccomendations($budget);
            if(empty($brideSalonList)){
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No Bride Dress Designers Found']);
            }
            for ($i = 0; $i < count($brideSalonList); $i++) {
                $brideSalonList[$i]['packageID'] = bin2hex($brideSalonList[$i]['packageID']);
                $brideSalonList[$i]['vendorID'] = bin2hex($brideSalonList[$i]['vendorID']);
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($brideSalonList);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getGroomDressDesignerReccomendations($parameters) {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $reccomendations = new Reccomendations();
            $brideSalonList = $reccomendations->getGroomDressDesignerReccomendations($budget);
            if(empty($brideSalonList)){
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No Bride Salons Found']);
            }
            for ($i = 0; $i < count($brideSalonList); $i++) {
                $brideSalonList[$i]['packageID'] = bin2hex($brideSalonList[$i]['packageID']);
                $brideSalonList[$i]['vendorID'] = bin2hex($brideSalonList[$i]['vendorID']);
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($brideSalonList);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getFloristReccomendations($parameters) {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $reccomendations = new Reccomendations();
            $brideSalonList = $reccomendations->getFloristReccomendations($budget);
            if(empty($brideSalonList)){
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No Bride Salons Found']);
            }
            for ($i = 0; $i < count($brideSalonList); $i++) {
                $brideSalonList[$i]['packageID'] = bin2hex($brideSalonList[$i]['packageID']);
                $brideSalonList[$i]['vendorID'] = bin2hex($brideSalonList[$i]['vendorID']);
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($brideSalonList);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }
}
