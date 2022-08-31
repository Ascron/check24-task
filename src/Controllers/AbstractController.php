<?php

namespace Ascron\Check24Task\Controllers;

use Ascron\Check24Task\App;

abstract class AbstractController implements ControllerInterface
{
    private App $app;

    public function beforeAction(App $app)
    {
        $this->app = $app;
    }
}