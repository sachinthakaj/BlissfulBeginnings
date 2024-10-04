<?php
class m0003_brideGrooms {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `bridegrooms` (
        brideGroomsID BINARY(16) PRIMARY KEY,
        name varchar(255) NOT NULL,
        email varchar(320) NOT NULL,
        contact varchar(10) NOT NULL,
        address varchar(255) NOT NULL,
        gender ENUM('Male', 'Female') NOT NULL,
        age INT NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE brideGrooms";
      $this->dbh->exec($SQL);
    }
};
