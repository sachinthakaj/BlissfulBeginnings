<?php
require_once 'Config.php';
loadEnv(__DIR__ . '/../.env');

class Database {

    

    private static $instance = null;

    private $dbh;  // Database handler
    private $stmt; // Statement handler
    private $error; // Store error if connection fails

    private function __construct() {
        // Set DSN (Data Source Name)
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';port='. $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'];
        $options = array(
            PDO::ATTR_PERSISTENT => true,   // Persistent connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Error mode
        );

        // Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log($this->error); // Show error if connection fails
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Prepare SQL query
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind parameters to the prepared statement
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute($params=null) {
        return $this->stmt->execute($params);
    }

    // Get result set as an array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get a single record as an object
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get the row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function fetch($type) {
        return $this->stmt->fetch($type);
    }
    public function fetchAll($type) {
        return $this->stmt->fetchAll($type);
    }
    public function fetchColumn(int $columnNumber=0) {
        return $this->stmt->fetchColumn($columnNumber);
    }

    public function lastId($name=null) {
        return $this->dbh->lastInsertId($name);
    }

    public function startTransaction() {
        return $this->dbh->beginTransaction();
    }
    public function rollbackTransaction() {
        return $this->dbh->rollBack();
    }
    public function commit() {
        return $this->dbh->commit();
    }

    public function getConnection() {
        return $this->dbh;
    }    
}
