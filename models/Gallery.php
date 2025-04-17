<?php

class Gallery
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createGallery($vendorID, $image, $path, $description, $display, $mime_type)
    {
        try {
            error_log("Create gallery function runs");
            $this->db->startTransaction();
            // $imageID = generateUUID($this->db);

            $sql = "INSERT INTO gallery (vendorID, image, path, description, display, mime_type) 
                    VALUES (UNHEX(:vendorID), :image, :path, :description, :display, :mime_type)";

            $this->db->query($sql);
            // $this->db->bind(':imageID', $imageID, PDO::PARAM_STR);
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->bind(':image', $image, PDO::PARAM_STR);
            $this->db->bind(':path', $path, PDO::PARAM_STR);
            $this->db->bind(':description', $description, PDO::PARAM_STR);
            $this->db->bind(':display', $display, PDO::PARAM_LOB);
            $this->db->bind(':mime_type', $mime_type, PDO::PARAM_STR);
            $this->db->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getImagesByVendorID($vendorID)
    {
        try {
            $sql = "SELECT path, description FROM gallery WHERE vendorID = UNHEX(:vendorID)";
            $this->db->query($sql);
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        
            $this->db->execute();
            $images = $this->db->fetchAll(PDO::FETCH_ASSOC);
        
            return $images;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteImageFromGallery($path, $vendorID) 
    {
      try {
        $imageName = basename($path);

        // Fetch image path before deleting
        $this->db->query("SELECT * FROM gallery WHERE path = :path AND vendorID = UNHEX(:vendorID)");
        $this->db->bind(':path', $path, PDO::PARAM_STR);
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $imageData = $this->db->single();
        
        if (!$imageData) {
            return false; // Image not found
        }
        
        // Delete the image record from the database
        $this->db->query("DELETE FROM gallery WHERE image = :image AND vendorID = UNHEX(:vendorID)");
        $this->db->bind(':image', $imageName, PDO::PARAM_STR);
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $result = $this->db->execute();
        
        // Delete the file from the server if it exists
        if (file_exists($path)) {
            unlink($path);
        }
        
        return $result; 
        } catch (PDOException $e) {
            if (isset($this->db) && method_exists($this->db, 'rollbackTransaction')) {
                $this->db->rollbackTransaction();
            }
            error_log($e->getMessage());
            throw $e;
        }
    }


    public function getImagePathByID($imageID, $vendorID)
    {
        try {
            $sql = "SELECT path FROM gallery WHERE imageID = UNHEX(:imageID) AND vendorID = UNHEX(:vendorID)";
            $this->db->query($sql);
            $this->db->bind(':imageID', $imageID, PDO::PARAM_STR);
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $image = $this->db->single();
            return $image;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateImageDescription($path, $vendorID, $description)
    {
        try {
            $this->db->startTransaction();

            // SQL query to update the image description (ensuring vendorID match)
            $sql = "UPDATE gallery SET description = :description 
                    WHERE path = :path AND vendorID = UNHEX(:vendorID)";

            error_log("Executing SQL: " . $sql);

            // Bind parameters
            $this->db->query($sql);
            $this->db->bind(':description', $description);
            $this->db->bind(':path', $path);  // image name
            $this->db->bind(':vendorID', $vendorID); 
            $this->db->execute();

            if ($this->db->rowCount() > 0) {
                $this->db->commit();
                return true; // Success
            } else {
                $this->db->rollbackTransaction();
                error_log("No rows affected.");
                return false; // No update happened
            }
        } catch (PDOException $e) {
            $this->db->rollbackTransaction(); // rollbackTransaction on error
            error_log("Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteImage($imageID)
    {
        try {
            $this->db->startTransaction();
        
            $this->db->query("
                DELETE FROM gallery 
                WHERE imageID = UNHEX(:imageID);
            ");
            $this->db->bind(":imageID", $imageID, PDO::PARAM_STR);
            $this->db->execute();
        
            $deletedRows = $this->db->rowCount(); // Check if any rows were deleted
        
            if ($deletedRows > 0) {
                $this->db->commit();
                return true; // Successfully deleted
            } else {
                $this->db->rollbackTransaction();
                return false; // No matching image found
            }
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Delete Error: " . $e->getMessage());
            throw $e;
        }
    }

}
