<?php

class Gallery
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createGallery($vendorID, $image, $path, $description, $display, $mime_type, $packageID)
    {
        try {
            error_log("Create gallery function runs");
            $this->db->startTransaction();
            // $imageID = generateUUID($this->db);

            $sql = "INSERT INTO gallery (vendorID, image, path, description, display, mime_type, packageID) 
                    VALUES (UNHEX(:vendorID), :image, :path, :description, :display, :mime_type, UNHEX(:packageID))";

            $this->db->query($sql);
            // $this->db->bind(':imageID', $imageID, PDO::PARAM_STR);
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->bind(':image', $image, PDO::PARAM_STR);
            $this->db->bind(':path', $path, PDO::PARAM_STR);
            $this->db->bind(':description', $description, PDO::PARAM_STR);
            $this->db->bind(':display', $display, PDO::PARAM_LOB);
            $this->db->bind(':mime_type', $mime_type, PDO::PARAM_STR);
            $this->db->bind(':packageID', $packageID, PDO::PARAM_STR);
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
            $sql = "SELECT path, description, packageID, created_at FROM gallery WHERE vendorID = UNHEX(:vendorID)";
            $this->db->query($sql);
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->execute();
            $images = $this->db->fetchAll(PDO::FETCH_ASSOC);
            for($i = 0; $i < count($images); $i++) {
                $images[$i]['packageID'] = bin2hex($images[$i]['packageID']);
            }
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

    public function updateImageDescription($path, $vendorID, $description, $packageID)
    {
        try {
            $this->db->startTransaction();

            // SQL query to update the image description (ensuring vendorID match)
            $sql = "UPDATE gallery SET description = :description, packageID = UNHEX(:packageID) 
                    WHERE path = :path AND vendorID = UNHEX(:vendorID)";

            error_log("Executing SQL: " . $sql);

            // Bind parameters
            $this->db->query($sql);
            $this->db->bind(':description', $description);
            $this->db->bind(':path', $path);  // image name
            $this->db->bind(':vendorID', $vendorID); 
            $this->db->bind(':packageID', $packageID); 
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

    public function orderByDesc($vendorID) {
        try {
            $this->db->startTransaction();
            $sql = "SELECT 
                        DATE_FORMAT(g.uploaded_at, '%M') AS upload_month,
                        GROUP_CONCAT(p.package_name) AS packages
                    FROM 
                        packages p
                    JOIN 
                        gallery g ON p.gallery_id = g.id
                    WHERE 
                        p.package_name LIKE 'T%' OR p.package_name LIKE 't%'
                    GROUP BY 
                        MONTH(g.uploaded_at);
                    ";
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Order by Desc Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function groupingByUploadedMonth($vendorID) {
        try {
            $this->db->startTransaction();
            $sql = "SELECT 
                        DATE_FORMAT(g.uploaded_at, '%M') AS upload_month,
                        GROUP_CONCAT(p.package_name ORDER BY p.package_name DESC) AS packages
                    FROM 
                        packages p
                    JOIN 
                        gallery g ON p.gallery_id = g.id
                    GROUP BY 
                        MONTH(g.uploaded_at);

                    ";
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Group by uploaded month Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function groupbypackagenameorderbyuploadedMonth($vendorID) {
        try {
            $this->db->startTransaction();
            $sql = "SELECT 
                        p.package_name,
                        DATE_FORMAT(g.uploaded_at, '%M') AS upload_month
                    FROM 
                        packages p
                    JOIN 
                        gallery g ON p.gallery_id = g.id
                    ORDER BY 
                        MONTH(g.uploaded_at) DESC;

                    ";
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Group by uploaded month Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function countofimagesbaseddonpackagename() {
        try {
            $this->db->startTransaction();
            $sql = "SELECT 
                        package_name,
                        COUNT(*) AS image_count
                    FROM 
                        gallery
                    GROUP BY 
                        package_name;
                    ;

                    ";
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Group by uploaded month Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function imagepathbaseonpackagenamedescending () {
        try {
            $this->db->startTransaction();
            $sql = "SELECT 
                        package_id,
                        COUNT(*) AS image_count
                    FROM 
                        gallery
                    GROUP BY 
                        package_id
                    ORDER BY 
                        image_count DESC
                    LIMIT 1;
                    ";
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Group by uploaded month Error: " . $e->getMessage());
            throw $e;
        }
    }
}
