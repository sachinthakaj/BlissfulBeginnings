<?php

class m0016_message {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
        $SQL = "
        CREATE TABLE `message` (
            `messageID` BINARY(16) PRIMARY KEY,
            `name` varchar(255) NOT NULL,    
            `email` varchar(255) NOT NULL,    
            `message` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
         
        CREATE TABLE newMessageNotifications (
            notificationID BINARY(16) PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            reference BINARY(16) NOT NULL,
            FOREIGN KEY (reference) REFERENCES message(messageID)  ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $this->dbh->exec($SQL);
    }

    public function down() {
        $SQL = "
        DROP TABLE `message`;";
        $this->dbh->exec($SQL);
    }
}
