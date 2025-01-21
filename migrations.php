<?php
// core/Database.php
require_once './core/Config.php';
loadEnv(__DIR__ . '/.env');

class Migrations
{
    private static $instance = null;

    private $dbh;  // Database handler
    private $stmt; // Statement handler
    private $error; // Store error if connection fails

    public function __construct()
    {
        // Set DSN (Data Source Name)
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'];
        $options = array(
            PDO::ATTR_PERSISTENT => true,   // Persistent connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Error mode
        );

        // Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error; // Show error if connection fails
        }
    }


    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedsMigrations();
        echo "aplliedMigrations: ";
        print_r($appliedMigrations);
        $files = scandir('./migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        echo "toApplyMigrations: ";
        print_r($toApplyMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' | $migration === '..') {
                continue;
            }
            echo $migration;
            require_once './migrations/' . $migration;

            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className($this->dbh);
            echo "Applying migration $migration" . PHP_EOL;
            try {
                $instance->up();
                if (method_exists($instance, 'alter')) {
                    $instance->alter();
                }

                echo "Applied migration $migration" . PHP_EOL;
                $this->saveMigration($migration, $instance);
            } catch (PDOException $th) {
                echo "here" .$th;
                echo $th;
                throw $th;
            }
        }
        echo "All migrations are applied";
    }

    public function saveMigrations(array $migrations)
    {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->dbh->prepare("INSERT INTO migrations (migration) VALUES 
        $str
        ;");
        $stmt->execute();
    }

    public function saveMigration($migration, $instance)
    {
        try {
            $stmt = $this->dbh->prepare("INSERT INTO migrations (migration) VALUES ('$migration');");
            $stmt->execute();
        } catch (Exception $e) {
            $instance->down();
            throw $e;
        }
    }
    public function createMigrationsTable()
    {
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

        return $statement->fetchall(PDO::FETCH_COLUMN);
    }

    public function undoLastMigration()
    {
        $statement = $this->dbh->prepare("SELECT * FROM migrations ORDER BY id DESC LIMIT 1;");
        $statement->execute();
        $lastMigration = $statement->fetch(PDO::FETCH_OBJ);
        require_once './migrations/' . $lastMigration->migration;
        $className = pathinfo($lastMigration->migration, PATHINFO_FILENAME);
        $instance = new $className($this->dbh);
        echo "Removing migration $lastMigration->migration" . PHP_EOL;
        $instance->down();
        echo "Removed migration $lastMigration->migration" . PHP_EOL;
        $statement = $this->dbh->prepare("DELETE FROM migrations WHERE id= $lastMigration->id");
        if ($statement->execute()) {
            echo "Migration with id $lastMigration->id removed successfully";
        };
    }

    public function undoAllMigrations()
    {
        $statement = $this->dbh->prepare("SELECT * FROM migrations ORDER BY id DESC;");
        $statement->execute();
        $migrations = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach ($migrations as $migration) {
            require_once './migrations/' . $migration->migration;
            $className = pathinfo($migration->migration, PATHINFO_FILENAME);
            $instance = new $className($this->dbh);
            echo "Removing migration $migration->migration" . PHP_EOL;
            $instance->down();
            echo "Removed migration $migration->migration" . PHP_EOL;
            $statement = $this->dbh->prepare("DELETE FROM migrations WHERE id= $migration->id");
            if ($statement->execute()) {
                echo "Migration with id $migration->id removed successfully";
            }
        }
        echo "All migrations are removed";	
    }
}

$shortopts = "ua";
$longopts = ["undo", "all"];

$options = getopt($shortopts, $longopts);

$migrations = new Migrations();


if (isset($options['u']) || isset($options['undo'])) {
    $migrations->undoLastMigration();
} else if (isset($options['a']) || isset($options['all'])) {
    $migrations->undoAllMigrations();
} else {
    $migrations->applyMigrations();
}
