<?php

namespace Jsdecena\Payjunction\Services\Invoices\Actions;

use Jsdecena\Payjunction\Services\Invoices\BaseInvoiceService;
use Jsdecena\Payjunction\Services\PayjunctionService;

class InvoiceReminderService extends BaseInvoiceService
{
    private PayjunctionService $service;

    private int $invoiceId;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/1260800369549-POST-invoices-invoiceId-void
     */
    public function __construct(int $invoiceId, PayjunctionService $service)
    {
        $this->invoiceId = $invoiceId;
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
    public function send(): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . "$this->endpoint/$this->invoiceId/send-reminder");
    }
}
