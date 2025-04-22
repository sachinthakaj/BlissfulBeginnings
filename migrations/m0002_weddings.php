<?php

class m0002_weddings {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = " 
      CREATE TABLE wedding (
        weddingID BINARY(16) PRIMARY KEY,
        userID BINARY(16)  NOT NULL,
        date date NOT NULL,
        dayNight enum('day', 'night') NOT NULL,
        location varchar(255) NOT NULL,
        theme varchar(255) NOT NULL,
        budget int,
        budgetMin INT,
        budgetMax INT,
        currentPaid int DEFAULT 0,
        numTasks int,
        currentCompleted int,
        sepSalons BOOLEAN, 
        sepDressDesigners BOOLEAN,
        weddingState ENUM('new', 'unassigned', 'ongoing', 'finished') NOT NULL,
        weddingPartyMale INT,
        weddingPartyFemale INT,
        

        CONSTRAINT fk_weds_ref_users FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
              $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE wedding";
      $this->dbh->exec($SQL);
    }
};