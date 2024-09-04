<?php
// Start the session
session_start();

// Load configuration
require_once '../config/config.php';

// Load helper functions
require_once '../helpers/auth.php';
require_once '../helpers/input.php';

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

// Define routes
switch ($request) {
    case '/':
    case '/home':
        $controller = new HomeController();
        $controller->index();
        break;

    case '/login':
        $controller = new AuthController();
        $controller->login();
        break;

    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case '/register':
        $controller = new AuthController();
        $controller->register();
        break;

    case '/profile':
        if (isLoggedIn()) {
            $controller = new UserController();
            $controller->profile();
        } else {
            header('Location: /login');
        }
        break;

    default:
        // Default to 404 page
        http_response_code(404);
        echo '404 Not Found';
        break;
}

