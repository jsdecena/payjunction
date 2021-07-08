<?php

namespace Jsdecena\Payjunction\Services\Customers\Notes\Exceptions;

use Exception;

class CustomerNoteException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message, 422);
    }
}
