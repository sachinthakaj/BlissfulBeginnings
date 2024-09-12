<?php

$router->get("/", "HomeController@index");
$router->get("/about", "HomeController@about");
$router->get("/register", "HomeController@Register");
$router->post("/register", "AuthController@register");
$router->get("/sign-in", "HomeController@signIn");
$router->get("/create-account", "HomeController@createAccount");
$router->get("/vendor-new-weddingg-dashboard", "HomeController@vendorNewWeddingDashboard");
$router->get("/vendor-signin", "HomeController@vendorSignIn");


$router->get("/contact", "HomeController@contact");
$router->get("/dashboard", "DashboardController@index");