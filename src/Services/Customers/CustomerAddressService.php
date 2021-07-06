<?php

namespace Jsdecena\Payjunction\Services\Customers;

use Jsdecena\Payjunction\Services\PayjunctionService;

class CustomerAddressService extends BaseCustomerService
{
    private PayjunctionService $service;

    private int $customerId;

    private string $addressEndpoint = '/addresses';

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/216543627-POST-customers-customerId-addresses
     */

    public function __construct(int $customerId, PayjunctionService $service)
    {
        $this->customerId = $customerId;
        $this->service = $service;
    }

    /**
     * Build the URL endpoint
     *
     * @param int|null $addressId
     *
     * @return string
     */
    public function buildUrl(int $addressId = null): string
    {
        $endpoint = $this->endpoint . "/$this->customerId/$this->addressEndpoint";
        if ($addressId) {
            $endpoint .= "/$addressId";
        }
        return $endpoint;
    }

    /**
     * Get all the customer addresses
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(array $queryParams = ['limit' => 50, 'offset' => 0]): \Psr\Http\Message\ResponseInterface
    {
        $buildUrl = $this->buildUrl() . '?' . http_build_query($queryParams);
        $query = $this->service->host . $buildUrl;

        return $this
            ->service
            ->http
            ->get($query, $this->service->headers);
    }

    /**
     * Create a customer address
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . $this->buildUrl(), [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific customer address
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(int $id): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . $this->buildUrl($id));
    }

    /**
     * Update the information of a specific customer address
     *
     * @param int $id
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->put($this->service->host . $this->buildUrl($id), [
            'form_params' => $data
        ]);
    }

    /**
     * Delete the information of a specific customer address
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $id): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->delete($this->service->host . $this->buildUrl($id));
    }
}
