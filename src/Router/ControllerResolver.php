<?php declare(strict_types=1);

namespace Ascron\Check24Task\Router;

class ControllerResolver
{
    private $callable = null;

    public function __construct(
        private string $controller,
        private string $action,
        private string $requestMethod
    ){}

    public function resolve(): bool
    {
        $controllerClass = 'Ascron\Check24Task\Controllers\\' . ucfirst($this->controller) . 'Controller';
        if (!class_exists($controllerClass)) {
            return false;
        }

        $controller = new $controllerClass();
        if (!method_exists($controller, ucfirst(strtolower($this->requestMethod)) . ucfirst($this->action))) {
            return false;
        }

        $this->callable = [$controller, $this->action];

        return true;
    }

    public function getCallable(): callable
    {
        return $this->callable;
    }
}