<?php

class m0017_unavailabledates {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {

         $SQL = "CREATE TABLE `features` (
         `featureID` BINARY(16) NOT NULL , 
         `packageID` BINARY(16) NOT NULL , 
         `feature` VARCHAR(255) NOT NULL , 
         PRIMARY KEY (`featureID`), 
         CONSTRAINT feature_refs_packages FOREIGN KEY(packageID) REFERENCES packages(packageID) ON DELETE CASCADE ON UPDATE CASCADE
         ) ENGINE = InnoDB;";
          



        $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE unavailabledates";
      $this->dbh->exec($SQL);
    }
}