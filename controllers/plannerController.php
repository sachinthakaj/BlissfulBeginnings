<?php

class PlannerController
{

    public function salonsList()
    {
        require_once '.\public\planner-salonList.html';
    }

    public function dressDesignersList()
    {
        require_once '.\public\planner-dressDesignerList.html';
    }

    public function photographersList()
    {
        require_once '.\public\planner-photographerList.html';
    }

    public function floristsList()
    {
        require_once '.\public\planner-floristList.html';
    }



    public function dashboard()
    {
        require_once './public/plannerDashboard.php';
    }

    public function fetchWeddingData()
    {
        try {
            if (!Authenticate('planner', 123)) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            }
            $weddingModel = new Wedding();
            $weddings = $weddingModel->getEveryWeddingData();
            header('Content-Type:application/json');
            echo json_encode($weddings);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function resetPassword()
    {
        require_once './public/resetPassword.html';
    }


    public function updateWeddingData()
    {


        if (!Authenticate('planner', 123)) {
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
        if (!Authenticate('planner', 123)) {
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

    public function showAllVendorsForWedding($parameters)
    {
        if (Authenticate('planner', 123)) {
            try {
                error_log('Here');
                
                    $vendorModel = new Vendor();
                    $vendors = $vendorModel->getAssignedVendors($parameters["weddingID"]);
                    if($vendors) {
                        header('Content-Type:application/json');
                        echo json_encode($vendors);
                    } else {
                        header('HTTP/1.1 204 No Content');
                        echo json_encode(['error' => 'No Vendors Found']);
                    }
                
            } catch (Exception $e) {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'Error fetching Data']);
            }
        } else {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
    }

    public function getTasksForAssignments($parameters)
    {
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        
            $taskModel = new Task();
            $assignmentID = $taskModel->tasksForAssignment($parameters['assignmentID']);
            header('Content-Type:application/json');
            echo json_encode($assignmentID);
        
    }

    public function createTasksForVendors($parameters)
    {
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            return;
        }
        $taskDetails = json_decode(file_get_contents("php://input"), true);
        $taskModel = new Task();
        $taskModel->createTask($taskDetails);
        header('Content-Type:application/json');
        echo json_encode(["status" => "success", "message" => "Task Successfully Created"]);
    }

    public function updateOfTasks($parameters)
    {
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        $taskDetails = json_decode(file_get_contents("php://input"), true);
        $taskModel = new Task();
        $taskModel->updateTask($taskDetails);
        header('Content-Type:application/json');
        echo json_encode(["status" => "success", "message" => "Task Successfully updated"]);
    }

    public function deleteOfTasks($parameters)
    {
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $taskID = $input["taskID"];
        $taskModel = new Task();
        $taskModel->deleteTask($taskID);
        header('Content-Type:application/json');
        echo json_encode(["status" => "success", "message" => "Task Successfully deleted"]);
    }



    public function getAllTasksForVendor()
    {
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
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
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
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
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
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
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
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
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
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

    public function fetchWedding($parameters)
    {
        try {
            if (!Authenticate('planner', 123)) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            }
            $plannerModel = new Planner();
            $wedding = $plannerModel->fetchWedding($parameters['weddingID']);
            if ($wedding) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($wedding);
            } else {
                header('HTTP/1.1 204 No Content');
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
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
        }
        try {
            $planerModel = new Planner();
            $notifications = $planerModel->getNotifications();
            if ($notifications) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($notifications);
            } else {
                header('HTTP/1.1 204 No Content');
                return;
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }
    public function vendorProfilePage($parameters)
    {
        require_once './public/VendorProfile.html';
    }

    public function vendorProfile($parameters)
    {
        try {
            if (!Authenticate('planner', 123)) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            };
            $vendorModel = new Vendor();
            error_log("Vendor ID: " . $parameters['vendorID']);
            $vendorPackages = $vendorModel->getVendorDetailsAndPackages($parameters['vendorID']);
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

    public function acceptVendor($parameters)
    {
        try {
            if (!Authenticate('planner', 123)) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
                return;
            };
            $plannerModel = new Planner();
            if ($plannerModel->acceptVendor($parameters['vendorID'])) {

                header('HTTP/1.1 200 OK');
                echo json_encode(['success' => 'Vendor Accepted Successfully']);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'Error accepting Vendor']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error accepting Vendor']);
        }
    }

    public function rejectVendor($parameters)
    {
        try {
            if (!Authenticate('planner', 123)) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            };
            $plannerModel = new Planner();
            if ($plannerModel->rejectVendor($parameters['vendorID'])) {
                header('HTTP/1.1 200 OK');
                echo json_encode(['success' => 'Vendor Rejected Successfully']);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'Error rejecting Vendor']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error rejecting Vendor']);
        }
    }
}
