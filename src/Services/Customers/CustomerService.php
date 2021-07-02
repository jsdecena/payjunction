<?php

namespace Jsdecena\Payjunction\Services\Customers;

use GuzzleHttp\Exception\GuzzleException;
use Jsdecena\Payjunction\Services\PayjunctionService;

class CustomerService
{
    private $service;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/sections/203755228-Customers
     */

    /** @var string $endpoint */
    private string $endpoint = '/customers';

    public function __construct(PayjunctionService $service)
    {
        $this->service = $service;
    }

    /**
     * Get all the customers
     *
     * @throws GuzzleException
     */
    public function all(array $queryParams = ['limit' => 50, 'offset' => 0])
    {
        $response = $this->service->http->get($this->service->host . $this->endpoint . '?' . http_build_query($queryParams));

        $jsonDecodeResponse = json_decode($response->getBody(), true);

        return $jsonDecodeResponse['results'];
    }

    /**
     * Create a customer
     *
     * @param array $data
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function store(array $data)
    {
        $response = $this->service->http->post($this->service->host . $this->endpoint, [
            'form_params' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function show(int $id)
    {
        $response = $this->service->http->get($this->service->host . $this->endpoint . '/' . $id);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     * @param array $data
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function update(int $id, array $data)
    {
        $response = $this->service->http->put($this->service->host . $this->endpoint . '/' . $id, [
            'form_params' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function delete(int $id)
    {
        $response = $this->service->http->delete($this->service->host . $this->endpoint . '/' . $id);

        return json_decode($response->getBody(), true);
    }
}
