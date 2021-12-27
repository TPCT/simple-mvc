<?php
date_default_timezone_set('Africa/Cairo');

use controllers\AuthController;
use core\Application;
use core\DotEnv;

include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "Application.php");
include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "DotEnv.php");

$env_reader = new DotEnv(__DIR__ . DIRECTORY_SEPARATOR . "db.env");
$env_reader->load();

$config = [
    'db' => [
        'dsn' => "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
        'db_user' => $_ENV['DB_USER'] ?? '',
        'db_pass' => $_ENV['DB_PASS'] ?? ''
        ]
    ];

$app = new Application(dirname(__DIR__), $config);


$app->router->get("/", [AuthController::class, 'login']);
$app->router->post("/", [AuthController::class, 'login']);

$app->run();
