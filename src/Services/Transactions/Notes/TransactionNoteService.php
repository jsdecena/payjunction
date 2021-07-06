<?php

namespace Jsdecena\Payjunction\Services\Transactions\Notes;

use Jsdecena\Payjunction\Services\PayjunctionService;
use Jsdecena\Payjunction\Services\Transactions\BaseTransactionService;

class TransactionNoteService extends BaseTransactionService
{
    private PayjunctionService $service;

    private int $transactionId;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/216543507-POST-customers-customerId-notes
     */
    private string $noteEndpoint = 'notes';

    public function __construct(int $transactionId, PayjunctionService $service)
    {
        $this->transactionId = $transactionId;
        $this->service = $service;
    }

    /**
     * @param string $type eg. latest|thermal|fullpage
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(string $type = 'latest'): \Psr\Http\Message\ResponseInterface
    {
        $query = $this->service->host . $this->endpoint . "/$this->transactionId/$this->noteEndpoint";

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
        return $this->service->http->post($this->service->host . $this->endpoint . "/$this->transactionId/$this->noteEndpoint", [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific transaction note
     *
     * @param int $noteId
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(int $noteId): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . $this->endpoint . "/$this->transactionId/$this->noteEndpoint/$noteId");
    }

    /**
     * Get the information of a specific transaction note
     *
     * @param int $noteId
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $noteId, array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->put($this->service->host . "/$this->transactionId/$this->noteEndpoint/$noteId", [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific transaction note
     *
     * @param int $noteId
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $noteId): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->delete($this->service->host . $this->endpoint . "/$this->transactionId/$this->noteEndpoint/$noteId");
    }
}
