<?php

namespace Jsdecena\Payjunction\Services\Customers;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Jsdecena\Payjunction\Factory\ClientFactory;
use Jsdecena\Payjunction\Services\BaseService;

class CustomerService extends BaseService
{
    /** @var string $endpoint */
    private string $endpoint = '/customers';

    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function all(array $queryParams = ['limit' => 50, 'offset' => 0])
    {
        $fromApiCall = (new ClientFactory())
            ->setUp()
            ->get($this->host . $this->endpoint . '?' . http_build_query($queryParams));

        $jsonDecodeResponse = json_decode($fromApiCall->getBody(), true);

        return $jsonDecodeResponse['results'];
    }
}
