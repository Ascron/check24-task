<?php declare(strict_types=1);

const APP_DIR = __DIR__ . '/../';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new \Ascron\Check24Task\App(
    new \Ascron\Check24Task\Router\Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']),
    new \Ascron\Check24Task\View\View()
);

return $app;