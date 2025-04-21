<?php

class MessageController
{
    private $messageModel;

    public function __construct()
    {
        $this->messageModel = new Message();
    }

    public function createMessage($parameters)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            // Get data from POST request
            $name = trim($data['name']);
            $email = trim($data['email']);
            $messageText = trim($data['message']);

            // var_dump($name, $email, $messageText);

            // Validate required fields
            if (empty($name) || empty($email) || empty($messageText)) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Name, email, and message are required.']);
                return;
            }

            // Generate unique message ID
            // $messageID = uniqid();

            // Save message info to DB
            $result = $this->messageModel->createMessage($name, $email, $messageText);

            if ($result) {
                header("Content-Type: application/json; charset=utf-8");
                echo json_encode([
                    "status" => "Message saved successfully"
                ]);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'Failed to save message in database']);
            }

        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'An error occurred while processing the message']);
        }
    }
}
