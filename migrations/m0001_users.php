<?php

class m0001_users {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "
      CREATE TABLE `users` (

        `userID` int(100) NOT NULL PRIMARY KEY AUTO_INCREMENT,

        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
              $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE users";
      $this->dbh->exec($SQL);
    }
}