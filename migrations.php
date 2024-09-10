<?php
// core/Database.php

class Migrations {

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'blissful_beginnings';

    private static $instance = null;

    private $dbh;  // Database handler
    private $stmt; // Statement handler
    private $error; // Store error if connection fails

    public function __construct() {
        // Set DSN (Data Source Name)
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,   // Persistent connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Error mode
        );

        // Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error; // Show error if connection fails
        }
    }
    
   
    public function applyMigrations() {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedsMigrations();
        $files = scandir('./migrations');
        print_r($files);
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        $newMigrations = [];
        foreach ($toApplyMigrations as $migration) {
            if($migration === '.' | $migration === '..') {
                continue;
            }
            require_once './migrations/'.$migration;
        }
        $className = pathinfo($migration, PATHINFO_FILENAME);
        $instance = new $className($dbh);
        echo "Applying migration $migration".PHP_EOL;
        $instance->up();
        echo "Applied migration $migration".PHP_EOL;

        $newMigrations[] = $migration;
    
        if(!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            echo "All migrations are applied";
        }

    }

    public function saveMigrations(array $migrations) {
        $str = array_map(fn($m) => "($m)", $migrations);
        $stmt = $this->dbh->prepare("INSERT INTO migrations (migrations) VALUES 
        $str
        ;");
        statement->execute();
    }

    public function createMigrationsTable() {
        $this->dbh->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
        ");
    }

    public function getAppliedsMigrations()
    {
        $statement = $this->dbh->prepare("SELECT migration  FROM  migrations;");
        $statement->execute();

        return $statement->fetchall();
    }
}

$migrations = new Migrations();
$migrations->applyMigrations();
