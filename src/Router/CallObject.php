<?php declare(strict_types=1);

namespace Ascron\Check24Task\Router;

use Ascron\Check24Task\Controllers\ControllerInterface;

class CallObject
{
    private ControllerInterface $controller;
    private string $action;
    private array $parameters;
    private array $formData;

    public function __construct(
        ControllerInterface $controller,
        string $action,
        ?array $parameters,
        ?array $formData
    ) {
        $this->controller = $controller;
        $this->action = $action;
        $this->parameters = $parameters;
        $this->formData = $formData;
    }

    public function getController(): ControllerInterface
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    public function getFormData(): ?array
    {
        return $this->formData;
    }

    public function getCallable(): callable
    {
        return [$this->getController(), $this->getAction()];
    }
}