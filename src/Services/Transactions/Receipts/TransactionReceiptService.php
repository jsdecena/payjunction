<?php

namespace Jsdecena\Payjunction\Services\Transactions\Receipts;

use Jsdecena\Payjunction\Services\PayjunctionService;
use Jsdecena\Payjunction\Services\Transactions\BaseTransactionService;

class TransactionReceiptService extends BaseTransactionService
{
    private PayjunctionService $service;

    private int $transactionId;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/216543507-POST-customers-customerId-notes
     */
    private string $receiptEndpoint = 'receipts';

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
        $query = $this->service->host . $this->endpoint . "/$this->transactionId/$this->receiptEndpoint/$type";

        return $this
            ->service
            ->http
            ->get($query, $this->service->headers);
    }
}
