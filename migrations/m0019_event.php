<?php

class m0019_event {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `event` (
    `eventID` BINARY(16) NOT NULL,
    `assignmentID` BINARY(16) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `date` DATE NOT NULL,
    `state` ENUM('scheduled', 'finished') NOT NULL,
    
    PRIMARY KEY (`eventID`),

    CONSTRAINT `fk_eventPackageAssignment` FOREIGN KEY (`assignmentID`) REFERENCES `packageAssignment`(`assignmentID`) ON DELETE CASCADE ON UPDATE CASCADE
   
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;   
";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE event";
      $this->dbh->exec($SQL);
    }
}