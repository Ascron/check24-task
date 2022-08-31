<?php declare(strict_types=1);


$app = new \Ascron\Check24Task\App(
    new \Ascron\Check24Task\Router\Router($_SERVER['REQUEST_URI']),
    new \Ascron\Check24Task\View\View()
);

return $app;