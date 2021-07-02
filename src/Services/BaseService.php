<?php

namespace Jsdecena\Payjunction\Services;

abstract class BaseService
{
    /** @var string */
    protected string $host;

    /**
     * BaseService constructor.
     */
    public function __construct()
    {
        $this->host = config('payjunction.host');
    }
}
