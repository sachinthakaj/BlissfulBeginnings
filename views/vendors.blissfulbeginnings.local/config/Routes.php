<?php

$router->get("/", "HomeController@index");
$router->get("/signin", "vendorAuthController@signInPage");
$router->post("/register", "vendorAuthController@registerAsVendor");
