<?php declare(strict_types=1);

namespace Ascron\Check24Task\Router;

use Ascron\Check24Task\Controllers\ControllerInterface;
use Ascron\Check24Task\Exceptions\NotFoundException;

class Router
{
    private $defaultRoute = ['article', 'list'];

    private ControllerInterface $controller;
    private string $action;

    public function __construct(
        private string $requestUri,
        private string $requestMethod
    ) {}

    public function findRoute(): CallObject
    {
        [$controller, $action, $parameters] = $this->parseUri();

        if ($controller == null && $action == null) {
            [$controller, $action] = $this->defaultRoute;
        }

        $resolver = new ControllerResolver($controller, $action, $this->requestMethod);
        if ($resolver->resolve() === false) {
            throw new NotFoundException();
        }

        [$controller, $action] = $resolver->getCallable();

        return new CallObject($controller, $action, $parameters, $_POST);
    }

    protected function parseUri(): array
    {
        $requestParts = explode('/', $this->requestUri);
        $controller = $requestParts[1] ?? null;
        $action = $requestParts[2] ?? null;

        if (count($requestParts)) {
            $parameters = array_slice($requestParts, 3);
        }

        return [$controller, $action, $parameters];
    }
}