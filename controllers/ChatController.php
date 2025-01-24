<?php

require_once '../../models/Chat.php';

class ChatController {
    public function uploadImage($params) {
        // Extract weddingID from the params
        $weddingID = $params['weddingID'] ?? null;

        if (!$weddingID) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Missing weddingID"]);
            return;
        }

        // Ensure a file was uploaded
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "No valid image file uploaded"]);
            return;
        }

        $file = $_FILES['image'];
        $metaData = json_decode($_POST['metaData'] ?? '{}', true);

        // Validate the file type (only allow images)
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedMimeTypes)) {
            http_response_code(400);
            echo json_encode(["error" => "Unsupported file type"]);
            return;
        }

        // Create a folder for the weddingID if it doesn't exist
        $uploadDir = dirname(__DIR__) . "/storage/chat/{$weddingID}";
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            http_response_code(500); // Internal Server Error
            echo json_encode(["error" => "Failed to create directory"]);
            return;
        }
        error_log($uploadDir);

        // Generate a unique filename and save the file
        $filename = uniqid('img_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $filePath = "{$uploadDir}/{$filename}";
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            http_response_code(500);
            echo json_encode(["error" => "Failed to save file"]);
            return;
        }

        // Convert file path to a relative URL for the client
        $relativePath = "/uploads/weddings/{$weddingID}/{$filename}";

        // Interact with the ChatModel to log the upload (if needed)
        $chatModel = new Chat();
        $chatModel->logImageUpload($weddingID, $relativePath, $metaData);

        // Send a JSON response with the file path
        echo json_encode(["storagePath" => $relativePath]);
    }
}
