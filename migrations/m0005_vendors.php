<?php

class m0005_vendors {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "
     CREATE TABLE vendors (
  vendorID Binary(16) Primary Key,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  businessName varchar(255) NOT NULL,
  typeID varchar(20) NOT NULL,
  contact varchar(255) NOT NULL,
  address varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  rating float default 0,
  imgSrc varchar(512)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
              $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE vendors";
      $this->dbh->exec($SQL);
    }
}