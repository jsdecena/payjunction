<?php

namespace Jsdecena\Payjunction\Services;

use GuzzleHttp\Client;

class PayjunctionService extends BaseService
{
    public string $host;

    /** @var Client $http Guzzle Client */
    public Client $http;

    /**
     * BaseService constructor.
     */
    public function __construct(Client $client)
    {
        $this->host = config('payjunction.host', $this->url);

//        $this->http = new Client([
//            'headers' => [
//                'Authorization' => 'Basic ' . base64_encode(config('payjunction.username', '') . ':' . config('payjunction.password', '')),
//                'X-PJ-Application-Key' => config('payjunction.app_key', '')
//            ]
//        ]);
        $this->http = $client;
    }
}
