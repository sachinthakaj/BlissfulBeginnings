<?php

class GalleryController
{
    private $galleryModel;

    public function __construct()
    {
        $this->galleryModel = new Gallery();
    }

    public function createGallery($parameters)
    {
        try {
            if (!Authenticate('vendor', $parameters['vendorID'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Authorization failed']);
                return;
            }

            if (!isset($_FILES['image'])) {
                http_response_code(400);
                echo json_encode(['error' => 'No file uploaded']);
                return;
            }

            $vendorID = $parameters['vendorID'];
            $file = $_FILES['image'];

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedMimeTypes)) {
                http_response_code(400);
                echo json_encode(["error" => "Unsupported file type"]);
                return;
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                http_response_code(400);
                echo json_encode(["error" => "File size exceeds 2MB"]);
                return;
            }

            $uploadDir = __DIR__ . '/vendorGalleries/' . $vendorID;
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
                http_response_code(500);
                echo json_encode(["error" => "Failed to create directory"]);
                return;
            }

            $filename = uniqid('img_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . DIRECTORY_SEPARATOR . $filename;

            if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                http_response_code(500);
                echo json_encode(["error" => "Failed to save file"]);
                return;
            }

            $imageID = $this->galleryModel->createGallery($vendorID, $filename, "");

            if (!$imageID) {
                http_response_code(500);
                echo json_encode(["error" => "Failed to store image in database"]);
                return;
            }

            echo json_encode([
                "imageID" => $imageID,
                "status" => "OK"
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(["error" => "Gallery Creation failed"]);
        }
    }
}
?>
