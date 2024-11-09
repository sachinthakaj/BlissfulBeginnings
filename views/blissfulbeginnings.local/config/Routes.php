<?php

$router->get("/", "HomeController@index");
$router->get("/about", "HomeController@about");
$router->get("/contact", "HomeController@contact");
$router->get("/services", "HomeController@services");
$router->get("/services/salons", "HomeController@salons");

$router->get("/register", "HomeController@Register");
$router->post("/register", "AuthController@register");

$router->get("/wedding-details", "WeddingController@create");
$router->post("/wedding-details", "WeddingController@newWedding");

$router->get("/signin", "HomeController@signIn");
$router->post("/signin","AuthController@login");

$router->get("/wedding/{weddingID}", "CustomerController@dashboard");
$router->get("/wedding/data/{weddingID}", "CustomerController@fetchData");

$router->get("/wedding/couple-details/{weddingID}", "CustomerController@fetchPersons");

$router->put("/update-wedding/{weddingID}","WeddingController@update");

$router->get("/package-assignments/{weddingID}", "CustomerController@packages");    
