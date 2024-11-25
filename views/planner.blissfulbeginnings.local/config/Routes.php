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




$router->get("/signin", "PlannerHomeController@signIn");
$router->post("/signin","PlannerAuthController@login");
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




$router->post("/wedding/{weddingID}/get-packages/salons","RecommendationsController@getSalonRecommendations");
$router->post("/wedding/{weddingID}/get-packages/bride-salons","RecommendationsController@getBrideSalonRecommendations");
$router->post("/wedding/{weddingID}/get-packages/groom-salons","RecommendationsController@getGroomSalonRecommendations");

$router->post("/wedding/{weddingID}/get-packages/dress-designers","RecommendationsController@getDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/bride-dress-designers", "RecommendationsController@getBrideDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/groom-dress-designers", "RecommendationsController@getGroomDressDesignerRecommendations");
$router->post("/wedding/{weddingID}/get-packages/florists","RecommendationsController@getFloristRecommendations");
$router->post("/wedding/{weddingID}/get-packages/photographers","RecommendationsController@getPhotographerRecommendations");


$router->post("/wedding/{weddingID}/submit-selected-packages","RecommendationsController@submitSelectedPackages");