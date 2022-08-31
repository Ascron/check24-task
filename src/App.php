<?php declare(strict_types=1);

namespace Ascron\Check24Task;

use Ascron\Check24Task\Exceptions\HttpException;
use Ascron\Check24Task\Router\Router;
use Ascron\Check24Task\View\View;

class App
{
    public function __construct(
        private Router $router,
        private View $view,
    )
    {}

    public function run(): string
    {
        try {
            $callable = $this->routeRequest();
            $response = $this->callAction($callable);
        } catch (HttpException $exception) {
            $response = $this->createErrorResponse($exception);
        }

        $this->displayResponse($response);
    }

    private function routeRequest(): callable
    {
        return $this->router->findRoute();
    }

    private function callAction(): string
    {
    }

    private function createErrorResponse(\Exception $exception): string
    {
        return $this->view->render('error', ['code' => $exception->getCode(), 'message' => $exception->getMessage()]);
    }

    private function displayResponse(string $response): void
    {
        echo $response;
    }
}