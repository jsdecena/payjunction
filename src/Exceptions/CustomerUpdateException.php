<?php

namespace Jsdecena\Payjunction\Exceptions;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

final class CustomerUpdateException extends Exception
{
    /**
     * CustomerNotFoundException constructor
     */
    public function __construct(GuzzleException $e)
    {
        parent::__construct($e, 400);
    }
}
