<?php
class m0005_insertValues {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `pissu` (
        `weddingID` BINARY(16)  PRIMARY KEY,
        `brideID` BINARY(16)  NOT NULL,
        `groomID` BINARY(16) NOT NULL,

  CONSTRAINT  FOREIGN KEY (weddingID) REFERENCES wedding(weddingID),
  CONSTRAINT groomID_fk FOREIGN KEY (brideID) REFERENCES brideGrooms(brideGroomsID),
  CONSTRAINT brideID_fk FOREIGN KEY (groomID) REFERENCES brideGrooms(brideGroomsID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE weddingbrideGrooms";
      $this->dbh->exec($SQL);
    }
};