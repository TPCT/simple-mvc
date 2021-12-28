<?php
date_default_timezone_set('Africa/Cairo');

use controllers\AuthController;
use core\Application;

include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "Application.php");

$app = new Application(dirname(__DIR__));


$app->router->get("/", [AuthController::class, 'login']);
$app->router->post("/", [AuthController::class, 'login']);

$app->run();
