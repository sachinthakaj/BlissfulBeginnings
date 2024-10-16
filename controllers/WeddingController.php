<?php


class WeddingController {
    private $weddingModel;

    public function __construct()
    {
        $this->weddingModel = new Wedding();
    }

    public function create() {
        require_once './views/WeddingDetails.php';
    }

    public function newWedding() {
        try {
            $_SESSION['userID'] = 0;
            Authenticate('user');
    
            $data = file_get_contents('php://input');
            // Decode the JSON into a PHP associative array
            $parsed_data = json_decode($data, true);
            $weddingDetails = $parsed_data['weddingDetails'];
            $brideDetails = $parsed_data['brideDetails'];
            $groomDetails = $parsed_data['groomDetails'];
            $weddingID = $this->weddingModel->createWedding($weddingDetails, $brideDetails, $groomDetails);
            header('Content-Type: application/json; charset=utf-8');
            error_log("Inserted a Wedding successfuly");
            echo json_encode(['message' => 'Created wedding successfully',
                    'weddingID'=> $weddingID,
        ]);
        } catch (Exception $error) {
            error_log($error);
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Registration failed']);
        }
       
    }


}
