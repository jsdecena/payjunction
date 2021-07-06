<?php

namespace Jsdecena\Payjunction\Services\Invoices\Actions;

use Jsdecena\Payjunction\Services\Invoices\BaseInvoiceService;
use Jsdecena\Payjunction\Services\PayjunctionService;

class InvoiceFilesService extends BaseInvoiceService
{
    private PayjunctionService $service;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/1260800369549-POST-invoices-invoiceId-void
     */
    public function __construct(PayjunctionService $service)
    {
        $this->service = $service;
    }

    /**
     * Void a customer invoice
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . "$this->endpoint/files", [
            'multipart' => $data
        ]);
    }
}
