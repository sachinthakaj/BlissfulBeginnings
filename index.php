<?php
// Start the session
session_start();

// Load configuration
require_once './config/config.php';
require_once './controllers/HomeController.php';



// Autoload classes from the 'models' and 'controllers' directories
spl_autoload_register(function ($class_name) {
    $paths = ['../models/', '../controllers/'];
    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Basic routing
$request = $_SERVER['REQUEST_URI'];

// Remove query string from the request URI
$request = strtok($request, '?');

$request = str_replace('/BlissfulBeginnings', '', $request);

// Define routes
switch ($request) {
    case '/':
    case '/home':
        echo 'here';
        $controller = new HomeController();
        $controller->index();
        break;



    default:
        // Default to 404 page
        http_response_code(404);
        echo '404 Not Found';
        break;
}

