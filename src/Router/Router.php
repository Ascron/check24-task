<?php declare(strict_types=1);

namespace Ascron\Check24Task\Router;

use Ascron\Check24Task\Exceptions\NotFoundException;

class Router
{
    public function __construct(
        private string $requestUri,
        private string $requestMethod
    ) {}

    public function findRoute(): callable
    {
        [$controller, $action, $parameters] = $this->parseUri();

        $resolver = new ControllerResolver($controller, $action, $this->requestMethod);
        if ($resolver->resolve() === false) {
            throw new NotFoundException();
        }

        return $resolver->getCallable();
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