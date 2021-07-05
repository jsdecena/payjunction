<?php

namespace Jsdecena\Payjunction\Services;

use GuzzleHttp\Client;

class PayjunctionService extends BaseService
{
    public string $host;

    /** @var Client $http Guzzle Client */
    public Client $http;

    public $headers;

    /**
     * BaseService constructor.
     */
    public function __construct(Client $client)
    {
        $this->host = config('payjunction.host', $this->url);

        $this->http = $client;
        $this->headers = $this->getHeaders();
    }
}
