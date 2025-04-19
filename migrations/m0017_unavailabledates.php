<?php

class m0017_unavailabledates {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {

         $SQL = "CREATE TABLE `unavailabledates` (
            `dateID` binary(16) NOT NULL,
            `vendorID` binary(16) NOT NULL,
            `unavailable_date` date NOT NULL,
            PRIMARY KEY (`dateID`),
            CONSTRAINT `unavailabledates_ibfk_1` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
          



        $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE unavailabledates";
      $this->dbh->exec($SQL);
    }
}