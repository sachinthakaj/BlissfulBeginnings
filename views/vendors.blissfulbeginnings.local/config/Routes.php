<?php

$router->get("/", "HomeController@index");
$router->get("/signin", "vendorAuthController@signInPage");
$router->get("/register", "vendorAuthController@Register");
$router->post("/register", "vendorAuthController@registerAsVendor");
$router->get("/edit-profile/{vendorID}", "vendorController@editProfilePage");
$router->get("/vendordashboard", "vendorAuthController@VendorDash");