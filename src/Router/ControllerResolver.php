<?php declare(strict_types=1);

namespace Ascron\Check24Task\Router;

use Ascron\Check24Task\Controllers\ControllerInterface;

class ControllerResolver
{
    private ControllerInterface $controller;
    private string $action;


    public function __construct(
        private string $controllerName,
        private string $actionName,
        private string $requestMethod
    ){}

    public function resolve(): bool
    {
        $controllerClass = 'Ascron\Check24Task\Controllers\\' . ucfirst($this->controllerName) . 'Controller';
        if (!class_exists($controllerClass)) {
            return false;
        }

        $this->controller = new $controllerClass();
        $this->action = ucfirst(strtolower($this->requestMethod)) . ucfirst($this->actionName);
        if (!method_exists($this->controller, $this->action)) {
            return false;
        }

        return true;
    }

    public function getController(): ControllerInterface
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}