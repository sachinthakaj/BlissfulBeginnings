<?php

class plannerController
{
    public function dashboard()
    {
        require_once './public/plannerDashboard.php';
    }

    public function fetchWeddingData()
    {
        $weddingModel = new Wedding();
        $weddings = $weddingModel->getEveryWeddingData();
        header('Content-Type:application/json');
        echo json_encode($weddings);
    }

    public function updateWeddingData()
    {
        session_start(); 

        
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode([
                "status" => "error",
                "message" => "Unauthorized: You must be logged in to perform this action"
            ]);
            return;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['weddingID'])) {
            $weddingID = $data['weddingID'];
        }

        $weddingModel = new Wedding();
        $weddingModel->updateNewtounassigned($weddingID);
        header('Content-Type:application/json');
        echo json_encode(["status" => "success", "message" => "Wedding State Successfully Update"]);
    }
    public function deleteWeddingData()
    {

        session_start();


        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode([
                "status" => "error",
                "message" => "Unauthorized: You must be logged in to perform this action"
            ]);
            return;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['weddingID'])) {
            $weddingID = $data['weddingID'];
            $weddingModel = new Wedding();
            $weddingModel->deleteFromPlannerDashboard($weddingID);

            header('Content-Type:application/json');
            echo json_encode(["status" => "success", "message" => "Wedding Successfully deleted"]);
        }
    }
    public function plannerWedding()
    {
        require_once './public/plannerWeddingPage.php';
    }
    public function selectPackages()
    {
        require_once './public/selectPackages.php';
    }
    public function selectPackages_saloon()
    {
        require_once './public/selectPackages-saloon.php';
    }

    public function selectPackages_dressmaker()
    {
        require_once './public/selectPackages-dressmaker.php';

    }
    public function selectPackages_photographer()
    {
        require_once './public/selectPackages-photographer.php';
    }
    public function selectPackages_decorator()
    {
        require_once './public/selectPackages-decorator.php';
    }


    public function getSalonsList()
    {
       
        try {
            $list1Model = new Planner();
            $salonList = $list1Model->getSalonsList();
            for($i = 0; $i < count($salonList); $i++) {
                $salonList[$i]['vendorID'] = bin2hex($salonList[$i]['vendorID']);
                }
            if($salonList) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($salonList);
            } else {
                header('HTTP/1.1 404 Unauthorized');
                echo json_encode(['error' => 'No Vendors Found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
}
public function getFloristsList()
    {
        try {
            $list2Model = new Planner();
            $floristList = $list2Model->getFloristsList();
            for($i = 0; $i < count( $floristList); $i++) {
                $floristList[$i]['vendorID'] = bin2hex( $floristList[$i]['vendorID']);
                }
            if($floristList) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode( $floristList);
            } else {
                header('HTTP/1.1 404 Unauthorized');
                echo json_encode(['error' => 'No Vendors Found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
}
public function getPhotographersList()
{
   
    try {
        $list3Model = new Planner();
        $photographerList = $list3Model->getPhotographersList();
        for($i = 0; $i < count($photographerList); $i++) {
            $photographerList[$i]['vendorID'] = bin2hex($photographerList[$i]['vendorID']);
            }
        if($photographerList) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($photographerList);
        } else {
            header('HTTP/1.1 404 Unauthorized');
            echo json_encode(['error' => 'No Vendors Found']);
        }
    } catch (Exception $e) {
        error_log($e);
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error fetching Data']);
    }
}
public function getDressDesignersList()
{
   
    try {
        $list4Model = new Planner();
        $dressDesignerList = $list4Model->getDressDesignersList();
        for($i = 0; $i < count( $dressDesignerList); $i++) {
            $dressDesignerList [$i]['vendorID'] = bin2hex( $dressDesignerList[$i]['vendorID']);
            }
        if($dressDesignerList) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($dressDesignerList);
        } else {
            header('HTTP/1.1 404 Unauthorized');
            echo json_encode(['error' => 'No Vendors Found']);
        }
    } catch (Exception $e) {
        error_log($e);
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error fetching Data']);
    }
}
}
