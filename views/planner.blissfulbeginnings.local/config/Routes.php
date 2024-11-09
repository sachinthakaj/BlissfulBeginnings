<?php

$router->get("/", "plannerController@dashboard");


$router->get("/signin", "PlannerHomeController@signIn");
$router->post("/signin","PlannerAuthController@login");
$router->get("/plannerWedding", "plannerController@plannerWedding");

