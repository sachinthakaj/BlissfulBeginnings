<?php
// Database configuration
define('DB_HOST', 'localhost');    // Database host, typically 'localhost'
define('DB_USER', 'root');         // Database username
define('DB_PASS', '');             // Database password
define('DB_NAME', 'blissful_beginnings'); // Database name

// Base URL
define('BASE_URL', 'http://localhost/'); // Change 'your_project_folder' to your actual project folder

// Application name
define('APP_NAME', 'Blissful Beginnings');

// Default timezone
date_default_timezone_set('Asia/Kolkata'); // Set the timezone for your application

ini_set('display_errors', 1); // Display errors on the screen during development


// Error reporting
ini_set('log_errors', 1);
ini_set('error_log', '../../logs/php_errors.log');  // Define the path to your log file
error_reporting(E_ALL);

