<?php

$router->get("/", "HomeController@index");

$router->get("/signin", "PlannerHomeController@signIn");
$router->post("/signin","PlannerAuthController@login");