<?php

$router->get("/", "plannerController@dashboard");


$router->get("/SignIn", "PlannerHomeController@signIn");
$router->post("/SignIn","PlannerAuthController@login");
$router->get("/plannerWedding", "plannerController@plannerWedding");
$router->get("/selectPackages","plannerController@selectPackages");
$router->get("/selectPackages-saloon","plannerController@selectPackages_saloon");
$router->get("/selectPackages-dressmaker","plannerController@selectPackages_dressmaker");
$router->get("/selectPackages-photographer","plannerController@selectPackages_photographer");
$router->get("/selectPackages-decorator","plannerController@selectPackages_decorator");

