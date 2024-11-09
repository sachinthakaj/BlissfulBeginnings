<?php

$router->get("/", "HomeController@index");
$router->get("/signin", "vendorAuthController@signInPage");
$router->post("/signin", "vendorAuthController@login");
$router->get("/register", "vendorAuthController@Register");
$router->post("/register", "vendorAuthController@registerAsVendor");
$router->get("/edit-profile/{vendorID}", "vendorController@editProfilePage");
$router->get("/dashboard", "vendorAuthController@VendorDash");