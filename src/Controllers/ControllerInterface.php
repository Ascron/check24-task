<?php declare(strict_types=1);

namespace Ascron\Check24Task\Controllers;

use Ascron\Check24Task\App;

interface ControllerInterface
{
    public function beforeAction(App $app);
}