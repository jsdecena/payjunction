<?php

namespace Jsdecena\Payjunction\Factory;

use Exception;
use GuzzleHttp\Client;

class ClientFactory
{
    private string $appKey;
    private Client $build;

    /**
     * Payjunction client constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->appKey = config('payjunction.app_key');

        if (!$this->appKey) {
            throw new Exception('You need to have the Payjunction APP KEY.', 401);
        }

        $this->build = new Client([
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('payjunction.username') . ':' . config('payjunction.password')),
                'X-PJ-Application-Key' => $this->appKey
            ]
        ]);
    }

    /**
     * @return Client
     */
    public function setUp(): Client
    {
        return $this->build;
    }
}
