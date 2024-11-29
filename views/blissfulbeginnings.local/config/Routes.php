<?php

$router->get("/", "HomeController@index");
$router->get("/about", "HomeController@about");
$router->get("/contact", "HomeController@contact");
$router->get("/services", "HomeController@services");
$router->get("/services/salons", "HomeController@salons");
$router->get("/services/dress-designers", "HomeController@dressDesigners");
$router->get("/services/photographers", "HomeController@photographers");
$router->get("/services/florists", "HomeController@florists");

$router->get("/vendor/{vendorID}","HomeController@vendorProfilePage");
$router->get("/vendor/vendor-details/{vendorID}","HomeController@vendorProfile");

$router->get("/get-salons","vendorController@getSalons");
$router->get("/get-photographers","vendorController@getPhotographers");
$router->get("/get-dressdesigners","vendorController@getDdesigners");
$router->get("/get-florists","vendorController@getFlorists");

$router->get("/register", "HomeController@Register");
$router->post("/register", "AuthController@register");

$router->get('change-password', "AuthController@changePasswordPage");
$router->post('change-password', "AuthController@changePassword");

$router->get("/wedding-details/{userID}", "WeddingController@create");
$router->post("/validate-userID/{userID}", "CustomerController@validateUserID");
$router->post("/wedding-details/{userID}", "WeddingController@newWedding");

$router->get("/signin", "HomeController@signIn");
$router->post("/signin","AuthController@login");

$router->get("/wedding/{weddingID}", "CustomerController@dashboard");
$router->get("/wedding/data/{weddingID}", "CustomerController@fetchData");
$router->delete("/wedding/delete-wedding/{weddingID}","CustomerController@deleteWedding");


$router->get("/wedding/couple-details/{weddingID}", "CustomerController@fetchPersons");

$router->put("/update-wedding/{weddingID}","WeddingController@update");

$router->post("/assign-packages/{weddingID}", "CustomerController@setPackages");    
$router->get("/assigned-packages/{weddingID}", "CustomerController@getAssignedPackages");    
$router->get("/reccomendations/{weddingID}", "CustomerController@getReccomendations");

$router->get("/resetpassword", "CustomerController@resetPassword");

