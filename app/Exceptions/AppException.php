<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class AppException
 * @package App\Exceptions
 */
class AppException extends HttpException
{
    const CODE = 500;

    public function __construct($message = "Internal Server Error")
    {
        parent::__construct($this::CODE, $message);
    }
}
