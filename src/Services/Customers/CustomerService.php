<?php

namespace Jsdecena\Payjunction\Services\Customers;

use Jsdecena\Payjunction\Services\Customers\Exceptions\CustomerException;
use Jsdecena\Payjunction\Services\PayjunctionService;

class CustomerService
{
    private PayjunctionService $service;

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(array $queryParams = ['limit' => 50, 'offset' => 0]): \Psr\Http\Message\ResponseInterface
    {
        $query = $this->service->host . $this->endpoint . '?' . http_build_query($queryParams);

        return $this
            ->service
            ->http
            ->get($query, $this->service->headers);
    }

    /**
     * Create a customer
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws CustomerException
     */
    public function store(array $data): \Psr\Http\Message\ResponseInterface
    {
        $rules = [
            'email' => ['required'],
            'firstName' => ['required'],
            'lastName' => ['required'],
        ];

        $validator = $this->service->validate($data, $rules);

        if (!empty($validator)) {
            throw new CustomerException(json_encode($validator));
        }

        return $this->service->http->post($this->service->host . $this->endpoint, [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(int $id): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . $this->endpoint . '/' . $id);
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->put($this->service->host . $this->endpoint . '/' . $id, [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific customers
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $id): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->delete($this->service->host . $this->endpoint . '/' . $id);
    }
}
