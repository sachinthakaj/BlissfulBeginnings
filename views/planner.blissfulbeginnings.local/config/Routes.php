<?php

$router->get("/", "plannerController@dashboard");

$router->get("/SignIn", "PlannerHomeController@signIn");
$router->post("/SignIn","PlannerAuthController@login");
$router->get("/newWedding", "plannerController@newWedding");

