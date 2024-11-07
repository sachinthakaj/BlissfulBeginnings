<?php

class m0007_packages {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE `packages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `vendorID` Binary(16)  NOT NULL,
        `name` varchar(255) NOT NULL,
        `description` varchar(511),
        `fixedCost` int(10) NOT NULL,

  CONSTRAINT Package_fk FOREIGN KEY (vendorID) REFERENCES vendors(vendorID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `photographyPackages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `cameraCoverage` int(10) NOT NULL,

  CONSTRAINT  FOREIGN KEY (packageID) REFERENCES packages(packageID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `dressmakerPackages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `variableCost` int(10) NOT NULL,
        `theme` varchar(255) NOT NULL,
        `demographic` ENUM('Bride', 'Groom', 'Both') NOT NULL,


  CONSTRAINT  FOREIGN KEY (packageID) REFERENCES packages(packageID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `salonPackages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `variableCost` int(10) NOT NULL,
        `demographic` ENUM('Bride', 'Groom', 'Both') NOT NULL,

  CONSTRAINT  FOREIGN KEY (packageID) REFERENCES packages(packageID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `floristPackages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `variableCost` int(10) NOT NULL,
        `type` ENUM('Fresh', 'Artificial') NOT NULL,

  CONSTRAINT  FOREIGN KEY (packageID) REFERENCES packages(packageID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE packages;
      DROP TABLE photographyPackages;
      DROP TABLE dressmakerPackages;
      DROP TABLE salonPackages;
      DROP TABLE floristPackages;";
      $this->dbh->exec($SQL);
    }
}