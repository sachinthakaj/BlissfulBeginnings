<?php

class m0013_Chat {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "
      CREATE TABLE `chat` (
        `messageID` BINARY(16) PRIMARY KEY,
        `weddingID` BINARY(16) NOT NULL,
        `role` ENUM('planner', 'customer') NOT NULL,
        `message` TEXT NOT NULL,
        `timestamp` TIMESTAMP,
              `relativePath` VARCHAR(511) NOT NULL,      


        CONSTRAINT fk_chat_ref_wedding FOREIGN KEY (weddingID) REFERENCES wedding(weddingID) ON DELETE CASCADE ON UPDATE CASCADE
      )";
      $this->dbh->exec($SQL);;
    }

    public function down() {
      $SQL = "
      DROP TABLE chat; ";
      $this->dbh->exec($SQL);
    }
}