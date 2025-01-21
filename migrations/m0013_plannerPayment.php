<?php

class m0013_plannerPayment {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `plannerPayment` (
        `paymentID` BINARY(16) NOT NULL,
        `assignmentID` BINARY(16) NOT NULL,
        `orderID` BINARY(16) NOT NULL,
        `payhereAmount` INT NOT NULL,
        `payhereCurrency` VARCHAR(255) NOT NULL,
        `date` DATE DEFAULT CURRENT_DATE,
        `time` TIME DEFAULT CURRENT_TIME,
        `statusCode` ENUM('2', '0', '-1', '-2', '-3') NOT NULL,
        

        PRIMARY KEY (`paymentID`),

        CONSTRAINT `fk1_packageAssignment` FOREIGN KEY (`assignmentID`) 
          REFERENCES `packageAssignment`(`assignmentID`) 
          ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
      
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE plannerPayment";
      $this->dbh->exec($SQL);
    }
}
