<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ServerErrorException extends HttpException
{
    public function __construct(string $message = 'Internal server error') {
        parent::__construct(500, $message);
    }
}
