<?php

class m0020_taskGroups {
    private $dbh;
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function up() {
      $SQL = "
    CREATE TABLE savedTasks (
        savedTaskID BINARY(16) PRIMARY KEY,
        Description VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;   

        CREATE TABLE savedTaskGroups (
            savedTaskGroupID BINARY(16) PRIMARY KEY , 
            typeID ENUM('photographer', 'salon', 'bride-salon', 'groom-salon', 'florist', 'bride-dress-designer', 'groom-dress-designer', 'dress-designer') NOT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        CREATE TABLE savedTasksToGroup (
            savedTaskID BINARY(16) NOT NULL,
            savedTaskGroupID BINARY(16) NOT NULL,
            PRIMARY KEY (savedTaskID, savedTaskGroupID),
            FOREIGN KEY (savedTaskID) REFERENCES savedTasks(savedTaskID) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (savedTaskGroupID) REFERENCES savedTaskGroups(savedTaskGroupID) ON DELETE CASCADE ON UPDATE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";
      $this->dbh->exec($SQL);
    }

    public function down() {
      $SQL = "DROP TABLE savedTasks;
      DROP TABLE savedTasksToGroup;
      DROP TABLE savedTaskGroups;";
      $this->dbh->exec($SQL);
    }
}