<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class BadRequestException extends HttpException
{
    public function __construct(string $message = 'Invalid request')
    {
        parent::__construct(400, $message);
    }
}
