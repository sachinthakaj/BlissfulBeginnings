<?php

$router->get("/plannerDashboard", "PlannerController@dashboard");
$router->get("/fetch-wedding-data", "PlannerController@fetchWeddingData");
$router->get("/fetch-wedding/{weddingID}", "PlannerController@fetchWedding");
$router->get("/fetch-assigned-vendors/{weddingID}", "PlannerController@showAllVendorsForWedding");

$router->post("/update-wedding-state","PlannerController@updateWeddingData");
$router->delete("/delete-wedding","PlannerController@deleteWeddingData");
$router->get("/tasks-for-assignments/{assignmentID}", "PlannerController@getTasksForAssignments");
$router->post("/tasks-create-for-vendors/{assignmentID}", "PlannerController@createTasksForVendors");
$router->get("/fetch-all-tasks", "PlannerController@getAllTasksForVendor");
$router->post("/update-tasks/{taskID}", "PlannerController@updateOfTasks");
$router->delete("/delete-tasks/{taskID}","PlannerController@deleteOfTasks");


$router->get("/wedding/{weddingID}/{assignmentID}","PlannerController@makePayments");
$router->get("/fetch-pakageData-to-pay/{assignmentID}","PlannerController@getDataToPay");
$router->get("/fetch-hash-for-paymentGateway/{assignmentID}","PlannerController@generateHashForPaymentGateway");
$router->post("/plannerPaymentData","PlannerController@getPaymentData");

$router->get("/fetch-for-budget-progress/{weddingID}", "PlannerController@getAmountToPayCustomer");
$router->get("/fetch-for-wedding-progress/{weddingID}", "PlannerController@getTasksDetailsForWeddingProgress");
$router->post("fetch_details_for_search","PlannerController@searchWedding");




$router->get("/signin", "PlannerAuthController@signIn");
$router->post("/signin","PlannerAuthController@login");
$router->post("/planner-logout","PlannerAuthController@logout");




$router->get("/wedding/{weddingID}", "PlannerController@plannerWedding");
$router->get("/selectPackages/{weddingID}","PlannerController@selectPackages");

$router->get("/wedding/data/{weddingID}", "customerController@fetchData");


$router->get("/salons", "PlannerController@salonsList");
$router->get("/dress-designers", "PlannerController@dressDesignersList");
$router->get("/photographers", "PlannerController@photographersList");
$router->get("/florists", "PlannerController@floristsList");



$router->get("/vendor/{vendorID}/accept", "PlannerController@acceptVendor");
$router->get("/vendor/{vendorID}/reject", "PlannerController@rejectVendor");


$router->get("/get-salonslist","PlannerController@getSalonsList");
$router->get("/get-floristlist","PlannerController@getFloristsList");
$router->get("/get-photographerslist","PlannerController@getPhotographersList");
$router->get("/get-dressdesignerslist","PlannerController@getDressDesignersList");

$router->get("/resetpassword", "PlannerController@resetPassword");




$router->post("/wedding/{weddingID}/get-packages/salon","RecommendationsController@getSalonRecommendations");
$router->post("/wedding/{weddingID}/get-packages/bride-salon","RecommendationsController@getBrideSalonRecommendations");
$router->post("/wedding/{weddingID}/get-packages/groom-salon","RecommendationsController@getGroomSalonRecommendations");

$router->post("/wedding/{weddingID}/get-packages/dress-designer","RecommendationsController@getDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/bride-dress-designer", "RecommendationsController@getBrideDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/groom-dress-designer", "RecommendationsController@getGroomDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/florist","RecommendationsController@getFloristRecommendations");
$router->post("/wedding/{weddingID}/get-packages/photographer","RecommendationsController@getPhotographerRecommendations");


$router->post("/wedding/{weddingID}/submit-selected-packages","RecommendationsController@submitSelectedPackages");


$router->get("/notifications", "PlannerController@notifications");

$router->get("/vendor/{vendorID}","PlannerController@vendorProfilePage");
$router->get("/vendor/vendor-details/{vendorID}","PlannerController@vendorProfile");


$router->post("/chat/upload-image/{weddingID}","ChatController@uploadImage");


$router->get("/complete-wedding/{weddingID}", "PlannerController@markWeddingAsComplete");
$router->get("/get-vendor-ratings/{weddingID}", "PlannerController@getVendorRatings");