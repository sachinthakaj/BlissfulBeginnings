<?php

$router->get("/plannerDashboard", "plannerController@dashboard");
$router->get("/fetch-wedding-data", "plannerController@fetchWeddingData");
$router->post("/update-wedding-state","plannerController@updateWeddingData");
$router->delete("/delete-wedding","plannerController@deleteWeddingData");
$router->get("/vendors-for-wedding", "plannerController@showAllVendorsForWedding");
$router->get("/task-vendors-for-wedding", "plannerController@linkTaskForVendors");
$router->post("/tasks-create-for-vendors", "plannerController@createTasksForVendors");
$router->get("/fetch-all-tasks", "plannerController@getAllTasksForVendor");
$router->post("/update-tasks", "plannerController@updateOfTasks");
$router->delete("/delete-tasks","plannerController@deleteOfTasks");




$router->get("/SignIn", "PlannerHomeController@signIn");
$router->post("/SignIn","PlannerAuthController@login");
$router->post("/planner-logout","PlannerAuthController@logout");




$router->get("/plannerWedding", "plannerController@plannerWedding");
$router->get("/selectPackages/{weddingID}","plannerController@selectPackages");

$router->get("/wedding/data/{weddingID}", "customerController@fetchData");

$router->get("/salons", "PlannerHomeController@salonsList");
$router->get("/dress-designers", "PlannerHomeController@dressDesignersList");
$router->get("/photographers", "PlannerHomeController@photographersList");
$router->get("/florists", "PlannerHomeController@floristsList");






$router->get("/get-salonslist","plannerController@getSalonsList");
$router->get("/get-floristlist","plannerController@getFloristsList");
$router->get("/get-photographerslist","plannerController@getPhotographersList");
$router->get("/get-dressdesignerslist","plannerController@getDressDesignersList");

$router->get("/resetpassword", "plannerController@resetPassword");




$router->post("/wedding/{weddingID}/get-packages/salon","RecommendationsController@getSalonRecommendations");
$router->post("/wedding/{weddingID}/get-packages/bride-salon","RecommendationsController@getBrideSalonRecommendations");
$router->post("/wedding/{weddingID}/get-packages/groom-salon","RecommendationsController@getGroomSalonRecommendations");

$router->post("/wedding/{weddingID}/get-packages/dress-designer","RecommendationsController@getDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/bride-dress-designer", "RecommendationsController@getBrideDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/groom-dress-designer", "RecommendationsController@getGroomDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/florist","RecommendationsController@getFloristRecommendations");
$router->post("/wedding/{weddingID}/get-packages/photographer","RecommendationsController@getPhotographerRecommendations");


$router->post("/wedding/{weddingID}/submit-selected-packages","RecommendationsController@submitSelectedPackages");


$router->get("/notifications", "plannerController@notifications");

$router->get("/vendor/{vendorID}","plannerController@vendorProfilePage");
$router->get("/vendor/vendor-details/{vendorID}","plannerController@vendorProfile");
