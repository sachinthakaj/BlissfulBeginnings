<?php

class m0014_customerPayment
{
  private $dbh;
  public function __construct($dbh)
  {
    $this->dbh = $dbh;
  }

  public function up()
  {
    $SQL = "CREATE TABLE `customerPayment` (
        `paymentID` BINARY(16) NOT NULL,
        `weddingID` BINARY(16) NOT NULL,
        `orderID` BINARY(16) NOT NULL,
        `amount` INT NOT NULL,
        `currency` VARCHAR(255) NOT NULL,
        `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `statusCode` ENUM('2', '0', '-1', '-2', '-3') NOT NULL,
        

        PRIMARY KEY (`paymentID`),

        CONSTRAINT `fk1_weddingPayment` FOREIGN KEY (`weddingID`) 
          REFERENCES `wedding`(`weddingID`) 
          ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $this->dbh->exec($SQL);
  }

  public function down()
  {
    $SQL = "DROP TABLE customerPayment";
    $this->dbh->exec($SQL);
  }
}
