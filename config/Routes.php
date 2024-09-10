<?php

$router->get("/", "HomeController@index");
$router->get("/about", "HomeController@about");
$router->get("/Register", "HomeController@Register");


$router->get("/contact", "HomeController@contact");
$router->get("/dashboard", "DashboardController@index");