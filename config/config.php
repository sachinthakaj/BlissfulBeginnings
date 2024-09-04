<?php
// Database configuration
define('DB_HOST', 'localhost');    // Database host, typically 'localhost'
define('DB_USER', 'root');         // Database username
define('DB_PASS', '');             // Database password
define('DB_NAME', 'your_database'); // Database name

// Base URL
define('BASE_URL', 'http://localhost/BlissfulBeginnings'); // Change 'your_project_folder' to your actual project folder

// Application name
define('APP_NAME', 'Blissful Beginnings');

// Default timezone
date_default_timezone_set('Asia/Kolkata'); // Set the timezone for your application

// Start the session (if not started in index.php)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Error reporting
error_reporting(E_ALL); // Enable all errors
ini_set('display_errors', 1); // Display errors on the screen during development

// Other application settings or constants
define('SOME_CONSTANT', 'some_value');
