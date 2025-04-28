<?php

$router->get("/", "HomeController@index");
$router->get("/signin", "vendorAuthController@signInPage");
$router->post("/signin", "vendorAuthController@login");
$router->get("/register", "vendorAuthController@Register");
$router->post("/register", "vendorAuthController@registerAsVendor");
$router->get("/vendor/{vendorID}", "vendorAuthController@VendorDash");
$router->get("/vendor/{vendorID}/get-weddings","vendorController@getWeddings");
$router->get("/resetpassword", "vendorHomeController@resetPassword");


$router->get("/packages/{vendorID}", "vendorController@editProfilePage");
$router->get("/edit-profile/vendor-details/{vendorID}", "vendorController@getVendorDetailsAndPackages");
$router->delete("/packages/delete/{packageID}", "PackageController@deletePackage");

$router->post("/vendor/{vendorID}/add-feature/{packageID}", "PackageController@createFeature");

$router->get("/vendor/{vendorID}/assignment/{assignmentID}", "vendorController@weddingDashboard");
$router->get("/vendor/{vendorID}/assignment/{assignmentID}/get-tasks", "vendorController@getTasks");
$router->get("/fetch_for_progress/{vendorID}/{assignmentID}", "vendorController@getForProgress");


$router->post("/vendor/{vendorID}/create-package", "PackageController@createPackage");
$router->post("/vendor/{vendorID}/delete-package/{packageID}", "PackageController@deletePackage");
$router->post("/vendor/{vendorID}/update-package/{packageID}", "PackageController@updatePackage");


$router->get("/get-profile-details/vendor-details/{vendorID}","vendorController@getProfileDetails");
$router->post("/update-profile/vendor-details/{vendorID}","vendorController@updateProfileDetails");
$router->delete("/delete-profile/vendor-details/{vendorID}","vendorController@deleteProfile");

$router->post("/vendor/set-unavailable/{vendorID}", "CalendarController@setUnavailableDate");
$router->get("/vendor/get-unavailable/{vendorID}", "CalendarController@getUnavailableDates");
$router->delete("/vendor/remove-unavailable/{vendorID}", "CalendarController@removeUnavailableDate");


$router->post("/task_state_update/{vendorID}","vendorController@updateOfTasks");


$router->get("/vendor/{vendorID}/assignment/{assignmentID}/get-wedding-id", "vendorController@getWeddingIDbyAssignmentID");

$router->post("/chat/upload-image/{weddingID}","ChatController@uploadImage");
$router->get("/get-events/{vendorID}/{assignmentID}","vendorController@getEventsForAnAssignment");
$router->post("/event-creation/{vendorID}","vendorController@createEvent");
$router->post("/update-event/{vendorID}","vendorController@updateEvent");
$router->post("/state-finished-events/{vendorID}","vendorController@saveFinishedEvents");
$router->post("/delete-event/{vendorID}","vendorController@deleteEvent");


