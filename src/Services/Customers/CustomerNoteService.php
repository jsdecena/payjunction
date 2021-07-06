<?php

namespace Jsdecena\Payjunction\Services\Customers;

use Jsdecena\Payjunction\Services\PayjunctionService;

class CustomerNoteService
{
    private $service;

    private $customerId;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/216543507-POST-customers-customerId-notes
     */

    /** @var string $endpoint */
    private string $endpoint = '/customers';

    public function __construct(int $customerId, PayjunctionService $service)
    {
        $this->customerId = $customerId;
        $this->service = $service;
    }

    /**
     * Get all the customers
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(array $queryParams = ['limit' => 50, 'offset' => 0]): \Psr\Http\Message\ResponseInterface
    {

        $buildUrl = $this->endpoint . "/$this->customerId/notes" . '?' . http_build_query($queryParams);
        $query = $this->service->host . $buildUrl;

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
     */
    public function store(array $data): \Psr\Http\Message\ResponseInterface
    {
        $buildUrl = $this->endpoint . "/$this->customerId/notes";
        return $this->service->http->post($this->service->host . $buildUrl, [
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
        $buildUrl = $this->endpoint . "/$this->customerId/notes" . '/' . $id;
        return $this->service->http->get($this->service->host . $buildUrl);
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
        $buildUrl = $this->endpoint . "/$this->customerId/notes" . '/' . $id;
        return $this->service->http->put($this->service->host . $buildUrl, [
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
        $buildUrl = $this->endpoint . "/$this->customerId/notes" . '/' . $id;
        return $this->service->http->delete($this->service->host . $buildUrl);
    }
}
