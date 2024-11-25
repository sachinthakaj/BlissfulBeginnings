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

public function getProfileDetails($parameters)
{
    try {
        $getProfiledetailsModel = new Vendor();
        error_log("Vendor ID: " . $parameters['vendorID']);
        $profileDetails =  $getProfiledetailsModel->getProfileDetails($parameters['vendorID']);
        $profileDetails['vendorID'] = bin2hex($profileDetails['vendorID']);
        if($profileDetails) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($profileDetails);
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
public function updateProfileDetails($parameters){
    try {
        $data = file_get_contents('php://input');
        // Decode the JSON into a PHP associative array
        $parsed_data = json_decode($data, true);
        $updateProfiledetailsModel = new Vendor();
        error_log("Vendor ID: " . $parameters['vendorID']);
        $updateDetails =  $updateProfiledetailsModel->updateProfileDetails($parameters['vendorID'], $parsed_data );
        
        if( $updateDetails) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode( $updateDetails);
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
public function deleteProfile($parameters){
    try {
        $data = file_get_contents('php://input');
        // Decode the JSON into a PHP associative array
        $parsed_data = json_decode($data, true);
        $deleteProfileModel = new Vendor();
        error_log("Vendor ID: " . $parameters['vendorID']);
        $deleteProfile =   $deleteProfileModel->deleteProfile($parameters['vendorID'], $parsed_data );
        
        if(  $deleteProfile ) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(  $deleteProfile );
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
