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

    public function resetPassword()
    {
        require_once './public/resetPassword.html';
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

    public function showAllVendorsForWedding()
    {
        $weddingID = $_GET["weddingID"];
        if (isset($weddingID)) {
            $vendorModel = new Vendor();
            $vendors = $vendorModel->getAllVendorsForWedding($weddingID);
            header('Content-Type:application/json');
            echo json_encode($vendors);
        }
    }

    public function linkTaskForVendors()
    {


        $vendorID = $_GET["vendorID"];
        $weddingID = $_GET["weddingID"];
        if (isset($weddingID)) {
            $taskModel = new Task();
            $assignmentID = $taskModel->getAssignmentIDfroAVendorofAWedding($weddingID, $vendorID);
            header('Content-Type:application/json');
            echo json_encode($assignmentID);
        }
    }

    public function createTasksForVendors()
    {
        $taskDetails = json_decode(file_get_contents("php://input"), true);
        $taskModel = new Task();
        $taskModel->createTask($taskDetails);
        header('Content-Type:application/json');
        echo json_encode(["status" => "success", "message" => "Task Successfully Created"]);
    }

    public function updateOfTasks()
    {
        $taskDetails = json_decode(file_get_contents("php://input"), true);
        $taskModel = new Task();
        $taskModel->updateTask($taskDetails);
        header('Content-Type:application/json');
        echo json_encode(["status" => "success", "message" => "Task Successfully updated"]);
    }

    public function deleteOfTasks()
    {
        
        $input = json_decode(file_get_contents("php://input"), true);
        $taskID = $input["taskID"];
        $taskModel = new Task();
        $taskModel->deleteTask($taskID);
        header('Content-Type:application/json');
        echo json_encode(["status" => "success", "message" => "Task Successfully deleted"]);
    }



    public function getAllTasksForVendor()
    {

        $assignmentID = $_GET["assignmentID"];
        if (isset($assignmentID)) {
            $taskModel = new Task();
            $tasks = $taskModel->getAllTasks($assignmentID);
            header('Content-Type:application/json');
            echo json_encode($tasks);
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
            for ($i = 0; $i < count($salonList); $i++) {
                $salonList[$i]['vendorID'] = bin2hex($salonList[$i]['vendorID']);
            }
            if ($salonList) {
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
            for ($i = 0; $i < count($floristList); $i++) {
                $floristList[$i]['vendorID'] = bin2hex($floristList[$i]['vendorID']);
            }
            if ($floristList) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($floristList);
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
            for ($i = 0; $i < count($photographerList); $i++) {
                $photographerList[$i]['vendorID'] = bin2hex($photographerList[$i]['vendorID']);
            }
            if ($photographerList) {
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
            for ($i = 0; $i < count($dressDesignerList); $i++) {
                $dressDesignerList[$i]['vendorID'] = bin2hex($dressDesignerList[$i]['vendorID']);
            }
            if ($dressDesignerList) {
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

    public function notifications()
    {
        $notifications = [
            [
                'id' => 1,
                'title' => 'New Vendor Added',
                'message' => 'A new vendor has been added to the system.',
                'typeID' => 'new-vendor',
                'reference' => 'vendor-123',
            ],
            [
                'id' => 2,
                'title' => 'New Package Added',
                'message' => 'A new package has been added to the system.',
                'typeID' => 'new-package',
                'reference' => 'package-456',
            ],
            [
                'id' => 3,
                'title' => 'Vendor Updated',
                'message' => 'A vendor has been updated in the system.',
                'typeID' => 'new-vendor',
                'reference' => 'vendor-789',
            ],
            [
                'id' => 4,
                'title' => 'Package Updated',
                'message' => 'A package has been updated in the system.',
                'typeID' => 'new-package',
                'reference' => 'package-012',
            ],
            [
                'id' => 5,
                'title' => 'New Vendor Added',
                'message' => 'Another new vendor has been added to the system.',
                'typeID' => 'new-vendor',
                'reference' => 'vendor-345',
            ],
        ];
        header('Content-Type:application/json');
        echo json_encode($notifications);
    }
    public function vendorProfilePage($parameters)
    {
        require_once './public/VendorProfile.html';
    }

    public function vendorProfile($parameters)
    {
        try {
            $packageModel = new Vendor();
            error_log("Vendor ID: " . $parameters['vendorID']);
            $vendorPackages = $packageModel->getVendorDetailsAndPackages($parameters['vendorID']);
            if ($vendorPackages) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($vendorPackages);
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid UserID']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Vendor Profile and Packages']);
        }
    }
}
