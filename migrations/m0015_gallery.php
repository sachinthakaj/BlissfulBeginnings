<?php

class m0015_gallery {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "
      CREATE TABLE `gallery` (
        `vendorID` BINARY(16) NOT NULL,
        `image` varchar(255) PRIMARY KEY NOT NULL,
        `mime_type` varchar(255) NOT NULL,
        `display` BLOB NOT NULL,
        `path` varchar(255) NOT NULL,
        `description` varchar(255) NOT NULL,    
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,   
        `associatedPackage` BINARY(16),

        CONSTRAINT fk_gallery_ref_package FOREIGN KEY (associatedPackage) REFERENCES packages(packageID) ON DELETE CASCADE ON UPDATE CASCADE, 
        CONSTRAINT fk_gallery_ref_vendor FOREIGN KEY (vendorID) REFERENCES vendors(vendorID) ON DELETE CASCADE ON UPDATE CASCADE
      )";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "
      DROP TABLE gallery; ";
      $this->dbh->exec($SQL);
    }
}