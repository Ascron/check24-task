<?php declare(strict_types=1);

namespace Ascron\Check24Task\Router;

use Ascron\Check24Task\Exceptions\NotFoundException;

class Router
{
    private string $requestUri;

    public function __construct(string $requestUri)
    {
        $this->requestUri = $requestUri;
    }

    public function findRoute(): callable
    {
        $requestParts = explode('/', $this->requestUri);
        $controller = $requestParts[1] ?? null;
        $action = $requestParts[2] ?? null;

        if ($controller === null || $action === null) {
            throw new NotFoundException();
        }
    }
}