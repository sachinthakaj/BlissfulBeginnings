<?php

// Allow requests from 'vendors.blissfulbeginnings.local'
header("Access-Control-Allow-Origin: http://vendors.blissfulbeginnings.com");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../models/vendor.php';
require_once '../core/Database.php';
require_once '../core/helpers.php';

$profilePhotoModel = new Vendor();


$vendorID = preg_replace("/[^a-zA-Z0-9_-]/", "", $_GET['vendorID']); // Sanitize input

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['vendorID'])) {
    $vendorID = preg_replace("/[^a-fA-F0-9]/", "", $_GET['vendorID']); // Ensure only valid hex characters
    $imagesData = $profilePhotoModel->getProfileDetails($vendorID);


    if ($imagesData) {
        echo json_encode($imagesData);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Image not found"]);
    }
    exit;
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['vendorID'])) {
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

    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    if (!in_array($file['type'], $allowedMimeTypes)) {
        http_response_code(400);
        echo json_encode(["error" => "Unsupported file type"]);
        return;
    }

    $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'profilePhotos';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to create directory"]);
        return;
    }

    $filename = 'img_' . $vendorID . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    // $description = isset($_POST['description']) ? trim($_POST['description']) : "";
    $filePath = $uploadDir . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        error_log("Upload failed! File path: $filePath");
        http_response_code(500);
        echo json_encode(["error" => "Failed to save file"]);
        return;
    }
    
    $relativePath = "/profilePhotos/{$filename}";
    // $imageContent = file_get_contents($filePath);
    // $mimeType = $file['type'];
    
    $imageID = $profilePhotoModel->createProfilePhoto($vendorID, $relativePath);

    if (!$imageID) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to store image in database"]);
        return;
    }

    echo json_encode(["status" => "OK", "vendorID" => $vendorID]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
}
?>
