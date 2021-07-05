<?php

namespace Jsdecena\Payjunction\Services;

abstract class BaseService
{
    protected $url = 'https://api.payjunctionlabs.com';

    /**
     * Default headers
     */
    protected function getHeaders(): array
    {
        return [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('payjunction.username', '') . ':' . config('payjunction.password', '')),
                'X-PJ-Application-Key' => config('payjunction.app_key', '')
            ]
        ];
    }
}
