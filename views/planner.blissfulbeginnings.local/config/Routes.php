<?php

$router->get("/plannerDashboard", "plannerController@dashboard");
$router->get("/fetch-wedding-data", "plannerController@fetchWeddingData");
$router->post("/update-wedding-state","plannerController@updateWeddingData");
$router->delete("/delete-wedding","plannerController@deleteWeddingData");



$router->get("/SignIn", "PlannerHomeController@signIn");
$router->post("/SignIn","PlannerAuthController@login");
$router->post("/planner-logout","PlannerAuthController@logout");




$router->get("/plannerWedding", "plannerController@plannerWedding");
$router->get("/selectPackages/{weddingID}","plannerController@selectPackages");
$router->get("/selectPackages/{weddingID/saloon","plannerController@selectPackages_saloon");
$router->get("/selectPackages/{weddingID}/dress-designer","plannerController@selectPackages_dressDesigner");
$router->get("/selectPackages/{weddingID}/photographer","plannerController@selectPackages_photographer");
$router->get("/selectPackages/{weddingID}/decorator","plannerController@selectPackages_decorator"); 

$router->get("/get-vendorlist","plannerController@getVendorList");

