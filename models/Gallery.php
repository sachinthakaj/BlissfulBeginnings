<?php

class Gallery
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createGallery($vendorID, $image, $description)
    {
        try {
            error_log("Create gallery function runs");
            $this->db->startTransaction();
            $imageID = generateUUID($this->db);

            $sql = "INSERT INTO gallery (imageID, vendorID, image, description) 
                    VALUES (UNHEX(:imageID), UNHEX(:vendorID), :image, :description)";

            $this->db->query($sql);
            $this->db->bind(':imageID', $imageID, PDO::PARAM_STR);
            $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
            $this->db->bind(':image', $image, PDO::PARAM_STR);
            $this->db->bind(':description', $description, PDO::PARAM_STR);
            $this->db->execute();

            $this->db->commit();
            return $imageID;
        } catch (PDOException $e) {
            $this->db->rollbackTransaction();
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }


    public function getImage($imageID, $vendorID)
    {
        $this->db->query("
            SELECT * FROM gallery 
            WHERE imageID = UNHEX(:imageID) AND vendorID = UNHEX(:vendorID);
        ");
        $this->db->bind(':imageID', $imageID, PDO::PARAM_STR);
        $this->db->bind(':vendorID', $vendorID, PDO::PARAM_STR);
        $this->db->execute();

        return $this->db->single(); // Fetch single image record
    }



    public function updateImageDescription($imageID, $vendorID, $description)
    {
        try {
            $this->db->startTransaction();

            // SQL query to update the image description (ensuring vendorID match)
            $sql = "UPDATE images SET description = :description 
                    WHERE imageID = UNHEX(:imageID) AND vendorID = UNHEX(:vendorID)";

            error_log("Executing SQL: " . $sql);

            // Bind parameters
            $this->db->query($sql);
            $this->db->bind(':description', $description);
            $this->db->bind(':imageID', $imageID);  // Assuming imageID is stored as BINARY(16)
            $this->db->bind(':vendorID', $vendorID); // Assuming vendorID is stored as BINARY(16)

            $this->db->execute();

            // Check if any row was updated
            if ($this->db->rowCount() > 0) {
                $this->db->commit();
                return true; // Success
            } else {
                $this->db->rollbackTransaction();
                error_log("No rows affected. Either imageID/vendorID is incorrect or the description is unchanged.");
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
