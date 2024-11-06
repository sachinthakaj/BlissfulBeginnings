<?php

class m0006_planner {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "
     CREATE TABLE planner (
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
 INSERT INTO planner VALUE ('123@gmail.com','$2y$10$6L.rZc45hil3/nY9pY2lROJxgK./YLl9QdgdSWaa8F3wkAashrYTm');";
              $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE planner";
      $this->dbh->exec($SQL);
    }
}