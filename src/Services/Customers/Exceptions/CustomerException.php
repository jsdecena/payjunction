<?php

namespace Jsdecena\Payjunction\Services\Customers\Exceptions;

use Exception;

class CustomerException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message, 422);
    }
}
