<?php

namespace Jsdecena\Payjunction\Exceptions;

use GuzzleHttp\Exception\GuzzleException;

final class CustomerNotFoundException extends \Exception
{
    /**
     * CustomerNotFoundException constructor
     */
    public function __construct(GuzzleException $e)
    {
        parent::__construct($e, 404);
    }
}
