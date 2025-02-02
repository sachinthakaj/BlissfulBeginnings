<?php


class RecommendationsController
{
    public function __construct() {}

    public function getSalonrecommendations($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $recommendations = new Recommendations();
            $brideSalonList = $recommendations->getSalonRecommendations($budget);
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

    public function getBrideSalonrecommendations($parameters)
    {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $recommendations = new Recommendations();
            $brideSalonList = $recommendations->getBrideSalonRecommendations($budget);
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

    public function getGroomSalonrecommendations($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $recommendations = new Recommendations();
            $brideSalonList = $recommendations->getGroomSalonRecommendations($budget);
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

    public function getPhotographerrecommendations($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $recommendations = new Recommendations();
            $brideSalonList = $recommendations->getPhotographerRecommendations($budget);
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

    public function getDressDesignerrecommendations($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $recommendations = new Recommendations();
            $brideSalonList = $recommendations->getDressDesignerRecommendations($budget);
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

    public function getBrideDressDesignerrecommendations($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $recommendations = new Recommendations();
            $brideSalonList = $recommendations->getBrideDressDesignerRecommendations($budget);
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

    public function getGroomDressDesignerrecommendations($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $recommendations = new Recommendations();
            $brideSalonList = $recommendations->getGroomDressDesignerRecommendations($budget);
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

    public function getFloristrecommendations($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $budget =  $parsed_data["allocatedBudget"];
            $recommendations = new Recommendations();
            $brideSalonList = $recommendations->getFloristrecommendations($budget);
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

    public function submitSelectedPackages($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $recommendationsModel = new Recommendations();
            $result = $recommendationsModel->createRecommendations($parameters['weddingID'], $parsed_data);
            if($result) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($result);
            } else {
                header('HTTP/1.1 404 Unauthorized');
                echo json_encode(['error' => 'No Vendors Found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error Submitting Data']);
        }
    }
  
}
