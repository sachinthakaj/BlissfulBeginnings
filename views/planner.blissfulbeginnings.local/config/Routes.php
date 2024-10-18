<?php

$router->get("/", "HomeController@index");

$router->get("/SignIn", "PlannerHomeController@signIn");
$router->post("/SignIn","PlannerAuthController@login");