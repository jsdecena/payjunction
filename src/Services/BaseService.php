<?php

namespace Jsdecena\Payjunction\Services;

use GuzzleHttp\Client;
use Jsdecena\Payjunction\Factory\ClientFactory;

abstract class BaseService
{
    /** @var string */
    protected string $host;

    /** @var Client $http Guzzle Client */
    protected Client $http;

    /**
     * BaseService constructor.
     */
    public function __construct()
    {
        $this->host = config('payjunction.host');

        $this->http = (new ClientFactory())->setUp();
    }
}
