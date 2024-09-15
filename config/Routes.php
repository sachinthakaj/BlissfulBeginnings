<?php

$router->get("/", "HomeController@index");
$router->get("/about", "HomeController@about");
$router->get("/register", "HomeController@Register");
$router->post("/register", "AuthController@register");


$router->get("/contact", "HomeController@contact");
$router->get("/dashboard", "DashboardController@index");
$router->get("/SignIn", "HomeController@CustomerSignIn");