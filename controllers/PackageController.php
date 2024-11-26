<?php
// Include necessary files


class PackageController
{

    private $packageModel;

    public function __construct()
    {
        // Initialize the User model
        $this->packageModel = new Package();
    }

    public function createPackage($parameters)
    {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);


            $packageID = $this->packageModel->createPackage($parameters["vendorID"], $parsed_data);
            if ($packageID) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode([
                    "packageID" => $packageID
                ]);
            }
        } catch (Exception $e) {
            var_dump($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Package Creation failed']);
        }
    }

    public function updatePackage($parameters)
    {
        try {
            $data = file_get_contents('php://input');
            $parsed_data = json_decode($data, true);
            $packageID = $this->packageModel->updatePackage($parameters["vendorID"], $parameters["packageID"], $parsed_data);
            if ($packageID) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode([
                    "packageID" => $packageID
                ]);
            }
        } catch (Exception $e) {
            var_dump($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Package Creation failed']);
        }
    }

    public function deletePackage($parameters) {
        if (!Authenticate('vendor', $parameters['packageID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $package = new Package();
            $result = $package->deletePackage($parameters['packageID']);
            if ($result > 0) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode(['message'=> "Package Deleted successfully"]);
            } else if ($result == 0) {
                header("HTTP/1.1 204 No Content");
                echo json_encode(['error' => 'Package not found']);
            } else {
                header('HTTP/1.1 409 Conflict');
                echo json_encode(['error' => 'Package is currently ongoing']);
            }
        } catch (Exception $e) {
            error_log($e);
        }
    }
}
