<?php declare(strict_types=1);

namespace Ascron\Check24Task;

use Ascron\Check24Task\Exceptions\HttpException;
use Ascron\Check24Task\Router\CallObject;
use Ascron\Check24Task\Router\Router;
use Ascron\Check24Task\View\View;

class App
{
    public function __construct(
        private Router $router,
        private View $view,
    )
    {}

    public function run(): void
    {
        try {
            $callObject = $this->routeRequest();
            $response = $this->callAction($callObject);
        } catch (HttpException $exception) {
            $response = $this->createErrorResponse($exception);
        }

        $this->displayResponse($response);
    }

    private function routeRequest(): CallObject
    {
        return $this->router->findRoute();
    }

    private function callAction(CallObject $callObject): string
    {
        call_user_func_array([$callObject->getController(), 'beforeAction'], [$this]);
        return call_user_func_array($callObject->getCallable(), [$callObject->getParameters(), $callObject->getFormData()]);
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