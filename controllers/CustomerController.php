<?php

class CustomerController
{
    public function dashboard()
    {
        require_once '.\public\CustomerWeddingDashboard.php';
    }

    public function fetchData($weddingID)
    {
        if (!Authenticate('customer', $weddingID)) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $wedding = new Wedding();
            $weddingDetails = $wedding->fetchDataCustomer($weddingID['weddingID']);
            if ($weddingDetails) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($weddingDetails);
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid UserID']);
            }
        } catch (Exception) {
        }
    }

    public function fetchPersons($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authorization failed']);
        }
        try {
            $wedding = new Wedding();
            $coupleDetails = $wedding->fetchDataCouple($parameters['weddingID']);
            if ($coupleDetails) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($coupleDetails, JSON_PRETTY_PRINT);
            } else {
                header('HTTP/1.1 404 NOT FOUND');
                echo json_encode(['error' => 'Invalid UserID']);
            }
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function packages($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Registration failed']);
        }
        try {
            $package = new Package();
            $packageDetails = $package->fetchWeddingPackages($parameters['weddingID']);
            if ($packageDetails) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode($packageDetails);
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Invalid UserID']);
            }
        } catch (Exception) {
        }
    }

    public function getReccomendations($parameters)
    {
        $data = [
            "Salons" => [
                [
                    "packageID" => "asdfasdfasd",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
                [
                    "packageID" => "asdfasdfasd1",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
                [
                    "packageID" => "asdfasdfasd2",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
            ],
            "Photographers" => [
                [
                    "packageID" => "asdfasdfasd3",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
                [
                    "packageID" => "asdfasdfasd4",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
                [
                    "packageID" => "asdfasdfasd5",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
            ],
            "Dressmakers" => [
                [
                    "packageID" => "asdfasdfasd6",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
                [
                    "packageID" => "asdfasdfasd7",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
                [
                    "packageID" => "asdfasdfasd8",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
            ],
            "Florists" => [
                [
                    "packageID" => "asdfasdfasd9",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
                [
                    "packageID" => "asdfasdfasd10",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
                [
                    "packageID" => "asdfasdfasd11",
                    "packageName" => "Deluxe",
                    "vendorID" => "afasdfasd",
                    "vendorName" => "asdfasdf",
                    "feature1" => "adfasdfasd",
                    "feature2" => "adfasdfasd",
                    "feature3" => "adfasdfasd",
                    "fixedCost" => 1234123
                ],
            ]

        ];

        echo json_encode($data);
    }
}
