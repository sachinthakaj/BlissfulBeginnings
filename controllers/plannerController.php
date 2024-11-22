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
}
