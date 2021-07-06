<?php

namespace Jsdecena\Payjunction\Services\Transactions;

use Jsdecena\Payjunction\Services\PayjunctionService;

class TransactionService
{
    private PayjunctionService $service;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/216477437-GET-transactions-transactionId-
     */

    /** @var string $endpoint */
    private string $endpoint = '/transactions';

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
     * Create a transaction
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . $this->endpoint, [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific transaction
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
     * Get the information of a specific transaction
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
     * @param int $transactionId
     * @param string $type eg. latest|thermal|fullpage
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showReceipts(int $transactionId, string $type = 'latest'): \Psr\Http\Message\ResponseInterface
    {
        $query = $this->service->host . $this->endpoint . "/$transactionId/receipts/$type";

        return $this
            ->service
            ->http
            ->get($query, $this->service->headers);
    }
}
