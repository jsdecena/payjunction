<?php

namespace Jsdecena\Payjunction\Services\Customers;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Jsdecena\Payjunction\Exceptions\CustomerCreateException;
use Jsdecena\Payjunction\Exceptions\CustomerNotFoundException;
use Jsdecena\Payjunction\Exceptions\CustomerUpdateException;
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
     */
    public function store(array $data)
    {
        try {
            $response = $this->http->post($this->host . $this->endpoint, [
                'form_params' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            return new CustomerCreateException($exception);
        }
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        try {
            $response = $this->http->get($this->host . $this->endpoint . '/' . $id);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            return new CustomerNotFoundException($exception);
        }
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     * @param array $data
     *
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        try {
            $response = $this->http->put($this->host . $this->endpoint . '/' . $id, [
                'form_params' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            return new CustomerUpdateException($exception);
        }
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     *
     * @return mixed
     * @throws CustomerNotFoundException
     */
    public function delete(int $id)
    {
        try {
            $response = $this->http->delete($this->host . $this->endpoint . '/' . $id);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            throw new CustomerNotFoundException($exception);
        }
    }
}
