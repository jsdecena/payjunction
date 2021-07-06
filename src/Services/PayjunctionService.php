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
    public function __construct(string $username, string $password, string $appKey, $isProduction = false, Client $client = null)
    {
        $this->setConfigurations($username, $password, $appKey);
        $this->host = $this->getHost($isProduction);
        $this->headers = $this->getHeaders();
        $this->http = $client ?? new Client($this->headers);
    }
}
