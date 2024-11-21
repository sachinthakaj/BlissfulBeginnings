<?php

$router->get("/", "plannerController@dashboard");
$router->get("/fetch-wedding-data", "plannerController@fetchWeddingData");
$router->get("/signin", "PlannerHomeController@signIn");
$router->post("/signin","PlannerAuthController@login");
$router->get("/plannerWedding", "plannerController@plannerWedding");
$router->get("/selectPackages/{weddingID}","plannerController@selectPackages");
$router->get("/selectPackages/{weddingID/saloon","plannerController@selectPackages_saloon");
$router->get("/selectPackages/{weddingID}/dress-designer","plannerController@selectPackages_dressDesigner");
$router->get("/selectPackages/{weddingID}/photographer","plannerController@selectPackages_photographer");
$router->get("/selectPackages/{weddingID}/decorator","plannerController@selectPackages_decorator");

