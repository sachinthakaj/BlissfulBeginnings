<?php

$router->get("/", "HomeController@test");
$router->get("/signin", "VendorAuthController@SignIn");
$router->get("/register", "VendorAuthController@Register");
