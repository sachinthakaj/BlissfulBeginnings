<?php

class HomeController {
    public function index() {
        require_once '.\public\Index.html';
    }
    public function register() {
        require_once '.\public\Register.php';
    }

    public function signIn() {
        require_once '.\public\CustomerSignIn.php';
    }

    public function createAccount() {
        require_once '.\public\CreateAnAccount.php';
    }

    public function about() {
        require_once '.\public\Index.html';
    }

    public function contact() {
        require_once '.\public\Index.html';
    }

    public function services() {
        require_once '.\public\Index.html';
    }

    public function salons() {
        require_once '.\public\Salons.php';
    }

    public function dressDesigners() {
        require_once '.\public\DressDesigners.php';
    }

    public function photographers() {
        require_once '.\public\Photographers.php';
    }

    public function florists() {
        require_once '.\public\Florists.php';
    }

    public function salonsList() {
        require_once '.\public\planner-salonList.html';
    }

    public function dressDesignersList() {
        require_once '.\public\planner-dressDesignerList.html';
    }

    public function photographersList() {
        require_once '.\public\photographerList.html';
    }

    public function floristsList() {
        require_once '.\public\planner-floristList.html';
    }

    public function vendorProfilePage($vendorID) {
        require_once '.\public\VendorProfile.html';
    }

    public function vendorProfile($parameters) {
        try {
            $packageModel = new Vendor();
            error_log("Vendor ID: " . $parameters['vendorID']);
            $vendorPackages = $packageModel->getVendorDetailsAndPackages($parameters['vendorID']);
            if($vendorPackages) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($vendorPackages);
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid UserID']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }
}

