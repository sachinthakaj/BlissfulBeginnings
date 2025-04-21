<?php

class m0018_p_unavailabledates {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {

         $SQL = "CREATE TABLE `p_unavailabledates` (
  `dateID` binary(16) NOT NULL,
  `unavailable_date` date NOT NULL,
    PRIMARY KEY (`dateID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

         $this->dbh->exec($SQL);
        }
    
        public function down() {
          $SQL = "DROP TABLE p_unavailabledates";
          $this->dbh->exec($SQL);
        }
    }


