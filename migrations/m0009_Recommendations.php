<?php

class m0009_Recommendations {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `recommendations` (
    `weddingID` BINARY(16) NOT NULL,
    `packageID` BINARY(16) NOT NULL,
    `typeID` ENUM('photographer', 'salon', 'bride-salon', 'groom-salon', 'florist', 'bride-dressd-dsigner', 'groom-dress-designer', 'dress-designer') NOT NULL,
    
    PRIMARY KEY (`weddingID`, `packageID`),

    CONSTRAINT `fk_recc_refs_weddings` FOREIGN KEY (`weddingID`) REFERENCES `wedding`(`weddingID`),
    CONSTRAINT `fk_recc_refs_packages` FOREIGN KEY (`packageID`) REFERENCES `packages`(`packageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;   
";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE recommendations";
      $this->dbh->exec($SQL);
    }
}