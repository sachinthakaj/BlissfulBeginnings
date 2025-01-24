<?php

class m0015_ChatImages {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `chatImages` (
        `weddingID` BINARY(16) NOT NULL,
        `imageID` BINARY(16) NOT NULL,
        `relativePath` VARCHAR(511) NOT NULL,        

        PRIMARY KEY (`imageID`),

        CONSTRAINT `chatImage_ref_wedding` FOREIGN KEY (`weddingID`) 
          REFERENCES `wedding`(`weddingID`) 
          ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
      
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE chatImages";
      $this->dbh->exec($SQL);
    }
}
