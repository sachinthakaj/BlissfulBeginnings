<?php

// Home Route
$request_uri = $_SERVER['REQUEST_URI'];

switch ($request_uri) {
    case '/':
        $controller = new HomeController();
        $controller->index();
        break;
    
    // Other routes...
    
    default:
        http_response_code(404);
        echo "Page Not Found";
        break;
}
