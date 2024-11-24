<?php

class vendorController
{
    private $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new vendor();
    }
    public function editProfilePage()
    {
        require_once '.\public\editProfile.html';
    }

    public function getVendorDetailsAndPackages($parameters)
    {
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

    
public function weddingDashboard($parameters) {
    require_once '.\public\VendorWeddingDashboard.php';}

    public function getSalons()
    {
        try {
            $salonModel = new Vendor();
            $salonList = $salonModel->getSalons();
            for($i = 0; $i < count($salonList); $i++) {
                $salonList[$i]['vendorID'] = bin2hex($salonList[$i]['vendorID']);
                }
            if($salonList) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($salonList);
            } else {
                header('HTTP/1.1 404 Unauthorized');
                echo json_encode(['error' => 'No Salons Found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
}

public function getPhotographers()
{
    try {
        $photoModel = new Vendor();
     
        $photographerList = $photoModel->getPhotographers();
        for($i = 0; $i < count( $photographerList); $i++) {
            $photographerList[$i]['vendorID'] = bin2hex( $photographerList[$i]['vendorID']);
            }
        if( $photographerList) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($photographerList);
        } else {
            header('HTTP/1.1 404 Unauthorized');
            echo json_encode(['error' => 'No photographers Found']);
        }
    } catch (Exception $e) {
        error_log($e);
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error fetching Data']);
    }
}

public function getDdesigners()
{
    try {
        $designerModel = new Vendor();
        $designerList = $designerModel->getDdesigners();
        for($i = 0; $i < count( $designerList); $i++) {
            $designerList[$i]['vendorID'] = bin2hex( $designerList[$i]['vendorID']);
            }
        if( $designerList) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode( $designerList);
        } else {
            header('HTTP/1.1 404 Unauthorized');
            echo json_encode(['error' => 'No designers Found']);
        }
    } catch (Exception $e) {
        error_log($e);
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error fetching Data']);
    }
}

public function getFlorists()
{
    try {
        $floristModel = new Vendor();
        $floristList = $floristModel->getFlorists();
        for($i = 0; $i < count( $floristList); $i++) {
            $floristList[$i]['vendorID'] = bin2hex( $floristList[$i]['vendorID']);
            }
        if( $floristList) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode( $floristList);
        } else {
            header('HTTP/1.1 404 Unauthorized');
            echo json_encode(['error' => 'No florists Found']);
        }
    } catch (Exception $e) {
        error_log($e);
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error fetching Data']);
    }
}

    public function getWeddings() {

    }
}
