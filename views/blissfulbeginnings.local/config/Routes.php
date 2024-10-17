<?php

$router->get("/", "HomeController@index");
$router->get("/about", "HomeController@about");
$router->get("/contact", "HomeController@contact");

$router->get("/register", "HomeController@Register");
$router->post("/register", "AuthController@register");

$router->get("/wedding-details", "WeddingController@create");
$router->post("/wedding-details", "WeddingController@newWedding");

$router->get("/SignIn", "HomeController@signIn");
$router->post("/SignIn","AuthController@login");

$router->get("/wedding/{weddingID}", "CustomerController@dashboard");
$router->get("/wedding/data/{weddingID}", "CustomerController@fetchData");


    
