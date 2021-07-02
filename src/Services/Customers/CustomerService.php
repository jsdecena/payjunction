<?php

namespace Jsdecena\Payjunction\Services\Customers;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Jsdecena\Payjunction\Services\BaseService;

class CustomerService extends BaseService
{
    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/sections/203755228-Customers
     */

    /** @var string $endpoint */
    private string $endpoint = '/customers';

    /**
     * Get all the customers
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function all(array $queryParams = ['limit' => 50, 'offset' => 0])
    {
        $response = $this->http->get($this->host . $this->endpoint . '?' . http_build_query($queryParams));

        $jsonDecodeResponse = json_decode($response->getBody(), true);

        return $jsonDecodeResponse['results'];
    }

    /**
     * Create a customer
     *
     * @param array $data
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function store(array $data)
    {
        $response = $this->http->post($this->host . $this->endpoint, [
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
     * @throws GuzzleException
     */
    public function show(int $id)
    {
        $response = $this->http->get($this->host . $this->endpoint . '/' . $id);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     * @param array $data
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function update(int $id, array $data)
    {
        $response = $this->http->put($this->host . $this->endpoint . '/' . $id, [
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
     * @throws GuzzleException
     */
    public function delete(int $id)
    {
        $response = $this->http->delete($this->host . $this->endpoint . '/' . $id);

        return json_decode($response->getBody(), true);
    }
}
