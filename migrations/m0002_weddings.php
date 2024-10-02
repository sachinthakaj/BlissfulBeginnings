<?php

class m0002_weddings {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = " 
      CREATE TABLE wedding (
        weddingID int(100) AUTO_INCREMENT PRIMARY KEY,
        userID int(100) NOT NULL,
        date date NOT NULL,
        dayNight varchar(255) NOT NULL,
        location varchar(255) NOT NULL,
        theme varchar(255) NOT NULL,
        budget int,
        currentPaid int,
        numTasks int,
        currentCompleted int,
        sepSalons BOOLEAN, 
        sepDressmakers BOOLEAN,
        weddingState ENUM('new', 'unassigned', 'ongoing', 'finished') NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
              $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE wedding";
      $this->dbh->exec($SQL);
    }
};