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
        `packageName` varchar(255) NOT NULL,
        `feature1` varchar(120) NOT NULL,
        `feature2` varchar(120),
        `feature3` varchar(120),
        `fixedCost` int(10) NOT NULL,

  CONSTRAINT Package_fk FOREIGN KEY (vendorID) REFERENCES vendors(vendorID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `photographyPackages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `cameraCoverage` int(10) NOT NULL,

  CONSTRAINT  FOREIGN KEY (packageID) REFERENCES packages(packageID)ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `dressDesignerPackages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `variableCostPerMale` int(10) NOT NULL,
        `variableCostPerFemale` int(10) NOT NULL,
        `theme` varchar(255) NOT NULL,
        `demographic` ENUM('Bride', 'Groom', 'Both') NOT NULL,


  CONSTRAINT  FOREIGN KEY (packageID) REFERENCES packages(packageID) ON DELETE CASCADE ON UPDATE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `salonPackages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `variableCostPerMale` int(10) NOT NULL,
        `variableCostPerFemale` int(10) NOT NULL,
        `demographic` ENUM('Bride', 'Groom', 'Both') NOT NULL,

  CONSTRAINT  FOREIGN KEY (packageID) REFERENCES packages(packageID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

      CREATE TABLE `floristPackages` (
        `packageID` BINARY(16)  PRIMARY KEY,
        `variableCostPerFemale` int(10) NOT NULL,
        `flowerType` ENUM('Fresh', 'Artificial') NOT NULL,

  CONSTRAINT  FOREIGN KEY (packageID) REFERENCES packages(packageID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "
      DROP TABLE photographyPackages;
      DROP TABLE dressDesignerPackages;
      DROP TABLE salonPackages;
      DROP TABLE floristPackages;
      DROP TABLE packages;";
      $this->dbh->exec($SQL);
    }
}