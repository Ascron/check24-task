<?php declare(strict_types=1);

namespace Ascron\Check24Task;

use Ascron\Check24Task\Database\DatabaseConnection;
use Ascron\Check24Task\Exceptions\Database\DatabaseException;
use Ascron\Check24Task\Exceptions\Http\HttpException;
use Ascron\Check24Task\Router\CallObject;
use Ascron\Check24Task\Router\Router;
use Ascron\Check24Task\View\View;

class App
{
    public function __construct(
        private Router $router,
        private View $view,
        private DatabaseConnection $databaseConnection
    )
    {}

    public function run(): void
    {
        try {
            $callObject = $this->routeRequest();
            $response = $this->callControllerAction($callObject);
        } catch (HttpException $exception) {
            $response = $this->createErrorResponse($exception);
        } catch (DatabaseException $exception) {
            // todo: logging
            $response = $this->createErrorResponse(new \Exception('Database error', 500));
        }

        $this->displayResponse($response);
    }

    private function routeRequest(): CallObject
    {
        return $this->router->findRoute();
    }

    private function callControllerAction(CallObject $callObject): string
    {
        call_user_func_array([$callObject->getController(), 'beforeAction'], [$this]);
        return call_user_func_array($callObject->getCallable(), [$callObject->getParameters(), $callObject->getFormData()]);
    }

    private function createErrorResponse(\Exception $exception): string
    {
        http_response_code($exception->getCode());
        return $this->view->render('error', ['code' => $exception->getCode(), 'message' => $exception->getMessage()]);
    }

    private function displayResponse(string $response): void
    {
        echo $response;
    }

    public function getDatabaseConnection(): DatabaseConnection
    {
        return $this->databaseConnection;
    }

    public function getView(): View
    {
        return $this->view;
    }
}