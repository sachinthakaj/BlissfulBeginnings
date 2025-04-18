<?php

class m0016_ratingsTrigger {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "
      CREATE TRIGGER `ratings` AFTER UPDATE ON `packageAssignment` FOR EACH ROW
      BEGIN
        IF NEW.rating != OLD.rating THEN
          UPDATE vendors SET rating = AVG(rating) WHERE vendorID = NEW.vendorID;
        END IF;
      END;";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "
      DROP TABLE gallery; ";
      $this->dbh->exec($SQL);
    }
}