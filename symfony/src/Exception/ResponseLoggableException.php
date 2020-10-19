<?php

namespace App\Exception;

use Throwable;

/**
 * ResponseLoggableException messages will be returned to the end user by showing them in the response
 *
 * Make sure this class is only used when the error messages do not contain any sensitive data
 *
 * @package App\Exception
 */
class ResponseLoggableException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}