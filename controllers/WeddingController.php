<?php


class WeddingController
{
    private $weddingModel;

    public function __construct()
    {
        $this->weddingModel = new Wedding();
    }

    public function create($parameters)
    {
        require_once './public/WeddingDetails.php';
    }

    public function newWedding($parameters)
    {
        try {
            if(Authenticate('user', $parameters['userID'])) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Registration failed']);
            }
            error_log("userID authentication successful");
            

            $data = file_get_contents('php://input');
            // Decode the JSON into a PHP associative array
            $parsed_data = json_decode($data, true);
            $weddingDetails = $parsed_data['weddingDetails'];
            $brideDetails = $parsed_data['brideDetails'];
            $groomDetails = $parsed_data['groomDetails'];
            $weddingID = $this->weddingModel->createWedding($weddingDetails, $brideDetails, $groomDetails, $parameters['userID']);  
            error_log("Inserted a Wedding successfuly. weddingID: $weddingID");
            $token = createToken($weddingID, 'customer');
            error_log("Created a token successfuly");
            header('HTTP/1.1 201 Created');
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'message' => 'Created wedding successfully',
                'token' => $token,
                'weddingID' => $weddingID,
            ]);
        } catch (Exception $error) {
            error_log($error);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Registration failed']);
        }
    }

    public function update($parameters)
    {
        if (!Authenticate('customer', $parameters['weddingID'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Authorization failed']);
        }
        try {
            $data = file_get_contents('php://input');
            // Decode the JSON into a PHP associative array
            $parsed_data = json_decode($data, true);
            $wedding = new Wedding();
            if ($wedding->updateWedding($parameters["weddingID"], $parsed_data)) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode([
                    'message' => 'wedding updated successfully',
                ]);
            }
        } catch (Exception $e) {
            error_log($e);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Update failed']);
        }
    }
}
