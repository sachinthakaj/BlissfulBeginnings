<?php

class m0006_planner {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = '
     CREATE TABLE planner (
  email varchar(255) PRIMARY KEY,
  password varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
 INSERT INTO `planner` VALUE (\'123@gmail.com\',\'$2y$10$Y8jpTwE5K2cM/ZZCC9xR5uWfEf9Np0pcXDjRkRjISR0Snk.vl/o1y\');';
              $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE planner";
      $this->dbh->exec($SQL);
    }
}