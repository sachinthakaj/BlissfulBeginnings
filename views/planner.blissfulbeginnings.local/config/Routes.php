<?php

$router->get("/plannerDashboard", "plannerController@dashboard");
$router->get("/fetch-wedding-data", "plannerController@fetchWeddingData");
$router->post("/update-wedding-state","plannerController@updateWeddingData");
$router->delete("/delete-wedding","plannerController@deleteWeddingData");



$router->get("/signin", "PlannerHomeController@signIn");
$router->post("/signin","PlannerAuthController@login");
$router->post("/planner-logout","PlannerAuthController@logout");




$router->get("/plannerWedding", "plannerController@plannerWedding");
$router->get("/selectPackages/{weddingID}","plannerController@selectPackages");
$router->get("/selectPackages/{weddingID/saloon","plannerController@selectPackages_saloon");
$router->get("/selectPackages/{weddingID}/dress-designer","plannerController@selectPackages_dressDesigner");
$router->get("/selectPackages/{weddingID}/photographer","plannerController@selectPackages_photographer");
$router->get("/selectPackages/{weddingID}/decorator","plannerController@selectPackages_decorator");


$router->get("/salons", "PlannerHomeController@salonsList");
$router->get("/dress-designers", "PlannerHomeController@dressDesignersList");
$router->get("/photographers", "PlannerHomeController@photographersList");
$router->get("/florists", "PlannerHomeController@floristsList");






$router->get("/get-salonslist","plannerController@getSalonsList");
$router->get("/get-floristlist","plannerController@getFloristsList");
$router->get("/get-photographerslist","plannerController@getPhotographersList");
$router->get("/get-dressdesignerslist","plannerController@getDressDesignersList");

$router->get("/resetpassword", "plannerController@resetPassword");



