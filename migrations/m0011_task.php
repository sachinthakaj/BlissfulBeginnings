<?php

class m0011_task {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `task` (
    `taskID` BINARY(16) NOT NULL,
    `assignmentID` BINARY(16) NOT NULL,
    `dateToFinish` DATE NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `state` ENUM('ongoing', 'finished') NOT NULL,
    
    PRIMARY KEY (`taskID`),

    CONSTRAINT `fk_packageAssignment` FOREIGN KEY (`assignmentID`) REFERENCES `packageAssignment`(`assignmentID`) ON DELETE CASCADE ON UPDATE CASCADE
   
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;   
";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE task";
      $this->dbh->exec($SQL);
    }
}