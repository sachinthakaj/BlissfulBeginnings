<?php


require "../../core/Router.php";
require "../../core/helpers.php";
require "../../core/Database.php";


const BASE_PATH = __DIR__ ;

// Load configuration
require_once './config/config.php';


// Autoload classes from the 'models' and 'controllers' directories
spl_autoload_register(function ($class_name) {
    $paths = ['../../models/', '../../controllers/'];
    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});



$router = Router::getRouter();
  require  "./config/routes.php";

  $method = $_SERVER['REQUEST_METHOD'];
  $uri = $_SERVER['REQUEST_URI'];
  $uri = str_replace('/BlissfulBeginnings', '', $uri);
  $router->route($method, $uri);




