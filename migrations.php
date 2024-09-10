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
        echo "Creating a migrations object";
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
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        $newMigrations = [];
        foreach ($toApplyMigrations as $migration) {
            if($migration === '.' | $migration === '..') {
                continue;
            }
            require_once './migrations/'.$migration;
        
        $className = pathinfo($migration, PATHINFO_FILENAME);
        $instance = new $className($this->dbh);
        echo "Applying migration $migration".PHP_EOL;
        $instance->up();
        echo "Applied migration $migration".PHP_EOL;

        $newMigrations[] = $migration;
        }
        if(!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            echo "All migrations are applied";
        }

    }

    public function saveMigrations(array $migrations) {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->dbh->prepare("INSERT INTO migrations (migration) VALUES 
        $str
        ;");
        $stmt->execute();
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

    public function undoLastMigration() {
        $statement = $this->dbh->prepare("SELECT * FROM migrations ORDER BY created_at DESC LIMIT 1;");
        $statement->execute();
        $lastMigration = $statement->fetch(PDO::FETCH_OBJ);
        require_once './migrations/'.$lastMigration->migration;
        $className = pathinfo($lastMigration->migration, PATHINFO_FILENAME);
        $instance = new $className($this->dbh);
        echo "Removing migration $lastMigration->migration".PHP_EOL;
        $instance->down();
        echo "Removed migration $lastMigration->migration".PHP_EOL;
        $statement = $this->dbh->prepare("DELETE FROM migrations WHERE id= $lastMigration->id");
        if($statement->execute()) {
            echo "Migration with id $lastMigration->id removed successfully";
        };
    }
}

$shortopts = "u";
$longopts = ["undo"];

$options = getopt($shortopts, $longopts);

var_dump($options);
$migrations = new Migrations();


if (isset($options['u']) || isset($options['undo'])) {
    $migrations->undoLastMigration();
} else {
    $migrations->applyMigrations();
}


