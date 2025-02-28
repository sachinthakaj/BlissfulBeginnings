<?php

require_once '../models/Gallery.php';
require_once '../core/Database.php';
require_once '../core/helpers.php';

// Allow requests from 'vendors.blissfulbeginnings.local'
header("Access-Control-Allow-Origin: http://vendors.blissfulbeginnings.com");

// Allow specific HTTP methods (e.g., GET, POST, OPTIONS)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// $data = file_get_contents('php://input');
// var_dump($data);
// $parsed_data = json_decode($data, true);
// echo $parsed_data['description'];
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$galleryModel = new Gallery();

if (isset($_GET['vendorID'])) {
    $vendorID = preg_replace("/[^a-zA-Z0-9_-]/", "", $_GET['vendorID']); // Sanitize input

    // Your file upload logic here
} else {
    http_response_code(400);
    echo "Invalid request";
}

if (!$vendorID) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Missing vendorID"]);
    return;
}
error_log($vendorID);


$file = $_FILES['image'] ?? null; //image to a variable

if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["error" => "File upload error: " . ($file['error'] ?? 'No file provided')]);
    return;
}
// Validate the file type (only allow images)
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($file['type'], $allowedMimeTypes)) {
    http_response_code(400);
    echo json_encode(["error" => "Unsupported file type"]);
    return;
}

// Create a folder for the vendorID if it doesn't exist
// $uploadDir = "/vendorGalleries/{$vendorID}";
$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'vendorGalleries' . DIRECTORY_SEPARATOR . $vendorID;
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to create directory"]);
    return;
}

// Generate a unique filename and save the file
$filename = uniqid('img_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
$description = isset($_POST['description']) ? trim($_POST['description']) : "";

// $filePath = "{$uploadDir}/{$filename}";
$filePath = $uploadDir . DIRECTORY_SEPARATOR . $filename;
if (!move_uploaded_file($file['tmp_name'], $filePath)) {
    error_log("Upload failed! File path: $filePath");
    http_response_code(500);
    echo json_encode(["error" => "Failed to save file"]);
    return;
} 

// Convert file path to a relative URL for the client
$relativePath = "/vendorGalleries/{$vendorID}/{$filename}";

$imageContent = file_get_contents($filePath); // Read the image file as binary

$imageID = $galleryModel->createGallery($vendorID, $filename, $relativePath, $description, $imageContent);

if (!$imageID) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to store image in database"]);
    return;
}

// Send a JSON response with the file path
echo json_encode(["storagePath" => $relativePath, "status" => "OK"]);
?>