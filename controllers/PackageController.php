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
            if (!Authenticate('vendor', $parameters['vendorID'])) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Authorization failed']);
            }
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
            if (!Authenticate('vendor', $parameters['vendorID'])) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Authorization failed']);
            }
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
}
