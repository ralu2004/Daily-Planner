<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use RalucaAdam\MyDailyPlanner\Router;

$router = new Router();
$router->route();
?>