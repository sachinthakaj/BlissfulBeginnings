<?php

require_once '../models/Gallery.php';
require_once '../core/Database.php';
require_once '../core/helpers.php';

// Allow requests from 'vendors.blissfulbeginnings.local'
header("Access-Control-Allow-Origin: http://vendors.blissfulbeginnings.com");
header("Access-Control-Allow-Methods: POST, GET, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$galleryModel = new Gallery();

$vendorID = preg_replace("/[^a-zA-Z0-9_-]/", "", $_GET['vendorID']); // Sanitize input

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['vendorID'])) {
    // Get request body content
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    if (!isset($data['path'])) {
        http_response_code(400);
        echo json_encode(["error" => "Image path not provided in request body"]);
        exit;
    }
    
    $imagePath = $data['path'];
    
    // Delete image from database and filesystem
    try {
        if ($galleryModel->deleteImageFromGallery($imagePath, $vendorID)) {
            echo json_encode(["success" => "Image deleted successfully"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Image not found or could not be deleted"]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Server error: " . $e->getMessage()]);
    }
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['vendorID'])) {
    $vendorID = preg_replace("/[^a-fA-F0-9]/", "", $_GET['vendorID']); // Ensure only valid hex characters
    $imagesData = $galleryModel->getImagesByVendorID($vendorID);

    if ($imagesData) {
        echo json_encode($imagesData);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Image not found"]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['vendorID'])) {
    if (!$vendorID) {
        http_response_code(400);
        echo json_encode(["error" => "Missing vendorID"]);
        return;
    }
    
    error_log($vendorID);
    
    $file = $_FILES['image'] ?? null;

    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(["error" => "File upload error: " . ($file['error'] ?? 'No file provided')]);
        return;
    }

    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedMimeTypes)) {
        http_response_code(400);
        echo json_encode(["error" => "Unsupported file type"]);
        return;
    }

    $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'vendorGalleries' . DIRECTORY_SEPARATOR . $vendorID;
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to create directory"]);
        return;
    }

    $filename = uniqid('img_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $description = isset($_POST['description']) ? trim($_POST['description']) : "";
    $filePath = $uploadDir . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        error_log("Upload failed! File path: $filePath");
        http_response_code(500);
        echo json_encode(["error" => "Failed to save file"]);
        return;
    }
    
    $relativePath = "/vendorGalleries/{$vendorID}/{$filename}";
    $imageContent = file_get_contents($filePath);
    $mimeType = $file['type'];
    
    $imageID = $galleryModel->createGallery($vendorID, $filename, $relativePath, $description, $imageContent, $mimeType);

    if (!$imageID) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to store image in database"]);
        return;
    }

    echo json_encode(["status" => "OK"]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
}
?>
