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

$router->get("/wedding/data/{weddingID}", "customerController@fetchData");

$router->get("/get-vendorlist","plannerController@getVendorList");

$router->post("/wedding/{weddingID}/get-packages/salons","ReccomendationsController@getSalonReccomendations");
$router->post("/wedding/{weddingID}/get-packages/bride-salons","ReccomendationsController@getBrideSalonReccomendations");
$router->post("/wedding/{weddingID}/get-packages/groom-salons","ReccomendationsController@getGroomSalonReccomendations");

$router->post("/wedding/{weddingID}/get-packages/dress-designers","ReccomendationsController@getDressmakerReccomendations");
$router->post("/wedding/{weddingID}/get-packages/bride-dress-designers", "ReccomendationsController@getBrideDressDesignerReccomendations");
$router->post("/wedding/{weddingID}/get-packages/groom-dress-designers", "ReccomendationsController@getGroomDressDesignerReccomendations");
$router->post("/wedding/{weddingID}/get-packages/florists","ReccomendationsController@getFloristReccomendations");
$router->post("/wedding/{weddingID}/get-packages/photographers","ReccomendationsController@getPhotographerReccomendations");
