<?php

$router->get("/", "HomeController@index");
$router->get("/signin", "vendorAuthController@signInPage");
$router->post("/signin", "vendorAuthController@login");
$router->get("/register", "vendorAuthController@Register");
$router->post("/register", "vendorAuthController@registerAsVendor");
$router->get("/vendor/{vendorID}", "vendorAuthController@VendorDash");
$router->get("/resetpassword", "vendorHomeController@resetPassword");


$router->get("/edit-profile/{vendorID}", "vendorController@editProfilePage");
$router->get("/edit-profile/vendor-details/{vendorID}", "vendorController@getVendorDetailsAndPackages");

$router->get("/vendor/{vendorID}/wedding/{weddingID}", "vendorController@weddingDashboard");


$router->post("/vendor/{vendorID}/create-package", "PackageController@createPackage");
$router->post("/vendor/{vendorID}/delete-package/{packageID}", "PackageController@deletePackage");
$router->post("/vendor/{vendorID}/update-package/{packageID}", "PackageController@updatePackage");


$router->get("/get-profile-details/vendor-details/{vendorID}","vendorController@getProfileDetails");
$router->post("/update-profile/vendor-details/{vendorID}","vendorController@updateProfileDetails");
$router->delete("/delete-profile/vendor-details/{vendorID}","vendorController@deleteProfile");