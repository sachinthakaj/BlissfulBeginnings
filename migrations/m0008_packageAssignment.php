<?php

class m0008_packageAssignment {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `packageAssignment` (
        `assignmentID` BINARY(16)  PRIMARY KEY,
        `weddingID` BINARY(16)  NOT NULL,
        `packageID` Binary(16)  NOT NULL,
        `typeID` ENUM('photographer', 'salon', 'bride-salon', 'groom-salon', 'florist', 'bride-dress-designer', 'groom-dress-designer', 'dress-designer') NOT NULL,
        `assignmentState` ENUM('agreed', 'unagreed') NOT NULL,
        `progress` decimal(5, 1) NOT NULL,
        `isPaid` BOOLEAN DEFAULT FALSE,


  CONSTRAINT WeddingID_fk FOREIGN KEY (weddingID) REFERENCES wedding(weddingID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT PackageID_fk FOREIGN KEY (packageID) REFERENCES packages(packageID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;     
";
      $this->dbh->exec($SQL);

    }

    public function down() {
      $SQL = "DROP TABLE packageAssignment";
      $this->dbh->exec($SQL);
    }

  
}