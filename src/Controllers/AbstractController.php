<?php declare(strict_types=1);

namespace Ascron\Check24Task\Controllers;

use Ascron\Check24Task\App;

abstract class AbstractController implements ControllerInterface
{
    protected App $app;

    public function beforeAction(App $app)
    {
        $this->app = $app;
    }
}