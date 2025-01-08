<?php

class m00014_packageAssignment_Update {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {

      $sql="ALTER TABLE `packageAssignment` ADD `isPaid` BOOLEAN DEFAULT FALSE;";
      $this->dbh->exec($sql);
    }

    public function down() {
      $SQL = "ALTER TABLE `packageAssignment` DROP COLUMN `isPaid`;";
      $this->dbh->exec($SQL);
    }

  
}