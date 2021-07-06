<?php

namespace Jsdecena\Payjunction\Services\Transactions\Receipts;

use Jsdecena\Payjunction\Services\Transactions\TransactionService;

class TransactionReceiptService extends TransactionService
{
    /**
     * @param int $transactionId
     * @param string $type eg. latest|thermal|fullpage
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fromTransaction(int $transactionId, string $type = 'latest'): \Psr\Http\Message\ResponseInterface
    {
        $query = $this->service->host . $this->endpoint . "/$transactionId/receipts/$type";

        return $this
            ->service
            ->http
            ->get($query, $this->service->headers);
    }
}
