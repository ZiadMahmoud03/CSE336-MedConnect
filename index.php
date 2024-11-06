<?php

session_start();

require "config/init.php";

$app = new App;
$app->loadController();

// $router = new Router();
// $router->route($_SERVER['REQUEST_URI']);


//loadController();
// echo "<pre>";
// print_r($segments);
// echo "</pre>";
