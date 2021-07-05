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
     * PayjunctionService constructor.
     */
    public function __construct(Client $client, string $username, string $password, string $appKey, $isProduction = false)
    {
        $this->setConfigurations($username, $password, $appKey);
        $this->http = $client;
        $this->host = $this->getHost($isProduction);
        $this->headers = $this->getHeaders();
    }
}
