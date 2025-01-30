<?php

class m0011_Notifications {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "CREATE TABLE newVendorNotifications (
  notificationID BINARY(16) PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  reference BINARY(16) NOT NULL,
  FOREIGN KEY (reference) REFERENCES vendors(vendorID)  ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE newPackageNotifications (
  notificationID BINARY(16) PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  reference BINARY(16) NOT NULL,
  FOREIGN KEY (reference) REFERENCES packages(packageID) ON DELETE CASCADE ON UPDATE CASCADE
);
";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE newVendorNotifications;
      DROP TABLE newPackageNotifications;";
      $this->dbh->exec($SQL);
    }
}