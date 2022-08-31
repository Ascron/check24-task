<?php declare(strict_types=1);

namespace Ascron\Check24Task\Exceptions;

class NotFoundException extends HttpException
{
    public function __construct()
    {
        parent::__construct('Not found', 404);
    }
}