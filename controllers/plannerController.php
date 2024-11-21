<?php

class plannerController {
    public function dashboard(){
        require_once './public/plannerDashboard.php';
       
    }

    public function fetchWeddingData(){
        $weddingModel = new Wedding();
        $weddings=$weddingModel->getEveryWeddingData();
        header('Content-Type:application/json');
        echo json_encode($weddings);
    }
    public function plannerWedding(){
        require_once './public/plannerWeddingPage.php';
    }
    public function selectPackages(){
        require_once './public/selectPackages.php';
    }
    public function selectPackages_saloon(){
        require_once './public/selectPackages-saloon.php';
    }
    public function selectPackages_dressDesigner(){
        require_once './public/selectPackages-dressDesigner.php';
    }
    public function selectPackages_photographer(){
        require_once './public/selectPackages-photographer.php';
    }
    public function selectPackages_decorator(){
        require_once './public/selectPackages-decorator.php';
    }


    public function getVendorList()
    {
        try {
            $listModel = new Vendor();
            $venList = $listModel->getVendorList();
            for($i = 0; $i < count($venList); $i++) {
                $venList[$i]['vendorID'] = bin2hex($venList[$i]['vendorID']);
                }
            if($venList) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($venList);
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