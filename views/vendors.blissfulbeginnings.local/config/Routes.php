<?php

$router->get("/", "HomeController@index");
$router->get("/signin", "vendorAuthController@signInPage");
$router->post("/signin", "vendorAuthController@login");
$router->get("/register", "vendorAuthController@Register");
$router->post("/register", "vendorAuthController@registerAsVendor");
$router->get("/vendor/{vendorID}", "vendorAuthController@VendorDash");


$router->get("/edit-profile/{vendorID}", "vendorController@editProfilePage");
$router->get("/edit-profile/vendor-details/{vendorID}", "vendorController@editProfile");


$router->post("/vendor/{vendorID}/create-package", "PackageController@createPackage");
$router->post("/vendor/{vendorID}/delete-package/{packageID}", "PackageController@deletePackage");
$router->post("/vendor/{vendorID}/update-package/{packageID}", "PackageController@updatePackage");