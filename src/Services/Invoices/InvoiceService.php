<?php

namespace Jsdecena\Payjunction\Services\Invoices;

use Jsdecena\Payjunction\Services\PayjunctionService;

class InvoiceService extends BaseInvoiceService
{
    private PayjunctionService $service;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/1260800369329-GET-invoices-invoiceId-
     */
    public function __construct(PayjunctionService $service)
    {
        $this->service = $service;
    }

    /**
     * Get all the customer invoices
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
     * Create a customer invoice
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
     * Get the information of a specific customer invoice
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
}
