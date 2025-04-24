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

    public function makePayments()
    {
        require_once './public/plannerWeddingPayment.php';
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
                if ($vendors) {
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
                echo json_encode(['error' => 'No Wedding Found']);
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

    public function getDataToPay($parameters)
    {


        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            exit;
        };
        try {
            $package = new Package();
            $result = $package->getPackageDataForPayments($parameters['assignmentID']);




            if ($result) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($result[0]);
            } else {
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'No package Found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }


    public function generateHashForPaymentGateway($parameters)
    {


        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            exit;
        };
        try {
            $package = new Package();
            $payment = new Payment();
            $order_id = $payment->createOrderIdForPaymentGateway();
            $merchant_id = "1228991";
            $merchant_secret = $_ENV['PAYHERE_SECRET'];
            $currency = "LKR";
            $packageData = $package->getPackageDataForPayments($parameters['assignmentID']);
            $temp = $packageData[0];
            $amount = $temp['fixedCost'];


            $hash = strtoupper(
                md5(
                    $merchant_id .
                        $order_id .
                        number_format($amount, 2, '.', '') .
                        $currency .
                        strtoupper(md5($merchant_secret))
                )


            );



            if ($hash) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['orderID' => $order_id, 'hash' => $hash]);
            } else {
                header('HTTP/1.1 204 No Content');
                echo json_encode(['error' => 'Hash ccould not create']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }


    public function getPaymentData()
    {


        try {
            $merchant_id         = $_POST['merchant_id'];
            $assignment_id       = $_POST['custom_1'];
            $order_id            = $_POST['order_id'];
            $payhere_amount      = $_POST['payhere_amount'];
            $payhere_currency    = $_POST['payhere_currency'];
            $status_code         = $_POST['status_code'];
            $md5sig              = $_POST['md5sig'];

            $merchant_secret = $_ENV['PAYHERE_SECRET']; // Replace with your Merchant Secret

            $local_md5sig = strtoupper(
                md5(
                    $merchant_id .
                        $order_id .
                        $payhere_amount .
                        $payhere_currency .
                        $status_code .
                        strtoupper(md5($merchant_secret))
                )
            );

            if (($local_md5sig === $md5sig) and ($status_code === "2")) {
                $payment = new Payment();
                $result = $payment->addPayment($assignment_id, $order_id, $payhere_amount, $payhere_currency, $status_code);
                if ($result == true) {
                    header('Content-Type:application/json');
                    echo json_encode(["status" => "success", "message" => "Payment Successfully Recorded"]);
                } else {
                    header('Content-Type:application/json');
                    echo json_encode(["status" => "failed", "message" => "Payment Failed to  Record"]);
                }
            } else {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Invalid Payment Details or Signature']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }

    public function getAmountToPayCustomer($parameters)
    {
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            exit;
        };
        try {
            $payment = new Payment();

            $amount = $payment->getAmountToPayCustomer($parameters['weddingID']);

            if ($amount) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($amount);
            } else {
                header('HTTP/1.1 404 Resource Not Found');
                echo json_encode(['error' => 'Resource not found']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting amount to pay']);
        }
    }

    public function getTasksDetailsForWeddingProgress($parameters)
    {
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            exit;
        };
        try {
            if (!isset($parameters['weddingID']) || empty($parameters['weddingID'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Bad Request: weddingID is required']);
                return;
            }

            $task = new Task();
            $tasks = $task->getAllTasksForAWedding($parameters['weddingID']);


            if (!empty($tasks)) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['status' => 'success', 'tasks' => $tasks]);
            } else {
                header('HTTP/1.1 404 Not Found');
                echo json_encode(['error' => 'No tasks found for the specified wedding']);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting tasks details']);
        }
    }


    public function searchWedding(){
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            exit;
        };
        try{
            $data = json_decode(file_get_contents('php://input'),true);
            //var_dump($data);
           
            if (!isset($data['str1']) || empty($data['str1']) && 
                !isset($data['str2']) || empty($data['str2'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Bad Request: brideName and groomName are required']);
                return;
            }

            $wedding = new Wedding();

            $searchedData = $wedding->getSerchedWeddingData($data['str1'],$data['str2']);

            if($searchedData) {
                header("HTTP/1.1 200 Okay");
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['status' => 'success','message' => 'searched successfully','weddings'=> $searchedData]);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['status'=>'error','error' => 'Error searching wedding data']);
            }

        } catch(Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error fetching Data']);
        }
    }


    public function markWeddingAsComplete($parameters)
    {
        if (!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            exit;
        };
        try {
            if (!isset($parameters['weddingID']) || empty($parameters['weddingID'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Bad Request: weddingID is required']);
                return;
            }
            $plannerModel = new Planner();
            $result = $plannerModel->markWeddingAsComplete($parameters['weddingID']);
            header("HTTP/1.1 200 Okay");
            echo json_encode(['result' => $result]);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error marking wedding as complete']);
        }
    }

    public function getVendorRatings($parameters) {
        if(!Authenticate('planner', 123)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized: You must be logged in to perform this action']);
            exit;
        }
        try {
            if (!isset($parameters['weddingID']) || empty($parameters['weddingID'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Bad Request: weddingID is required']);
                return;
            }
            $plannerModel = new Planner();
            $result = $plannerModel->getVendorRatings($parameters['weddingID']);
            header("HTTP/1.1 200 Okay");
            echo json_encode($result);
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error getting vendor ratings']);
        }
    }

    public function deleteVendors($parameters) // Changed parameter name
{
    try {
        $vendorModel = new Vendor(); // Fixed variable name
        error_log("Vendor ID: " . $parameters['vendorID']);
        
        $result = $vendorModel->deleteVendor( $parameters['vendorID']);

        if ($result > 0) {
            header("Content-Type: application/json");
            http_response_code(200); // Success
            echo json_encode(['success' => true, 'message' => 'Vendor deleted successfully']);
        } else if ($result === -1) {
            header("Content-Type: application/json");
            http_response_code(409); // Conflict
            echo json_encode(['error' => 'Vendor has ongoing weddings']);
        } else if ($result === 0) {
            header("Content-Type: application/json");
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Vendor not found']);
        }
    } catch (Exception $e) {
        error_log($e);
        header("Content-Type: application/json");
        http_response_code(500); // Server Error
        echo json_encode(['error' => 'Server error while deleting vendor']);
    }
}
}
