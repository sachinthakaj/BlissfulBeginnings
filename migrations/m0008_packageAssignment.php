<?php

class m0008_packageAssignment {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `packageAssignment` (
        `weddingID` BINARY(16)  NOT NULL,
        `packageID` Binary(16)  NOT NULL,
        `state` varchar(255) NOT NULL,
        `progress` varchar(511),

  CONSTRAINT WeddingID_fk FOREIGN KEY (weddingID) REFERENCES wedding(weddingID),
  CONSTRAINT PackageID_fk FOREIGN KEY (packageID) REFERENCES packages(packageID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;     
";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE packageAssignment";
      $this->dbh->exec($SQL);
    }
}