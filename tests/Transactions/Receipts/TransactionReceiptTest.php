<?php

namespace Jsdecena\Payjunction\Tests\Transactions\Receipts;

use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\Transactions\Receipts\TransactionReceiptService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class TransactionReceiptTest extends BaseTestCase
{
    private TransactionReceiptService $transactionReceiptService;

    public function setUp(): void
    {
        parent::setUp();
        $this->transactionReceiptService = new TransactionReceiptService(1, $this->service);
    }

    public function getMockResponse(Response ...$response): array
    {
        return [
            new Response(200, [], json_encode([$this->transactionReceiptMock()])), // All transaction receipts
        ];
    }

    private function transactionReceiptMock(): array
    {
        return [
            "uri" => "https://api.payjunction.com/transactions/10409/receipts/latest",
            "signatureStatus" => "SIGNED",
            "terms" => "4.20",
            "signatureUpToDate" => true,
            "created" => "2014-01-08T00:02:40Z",
            "lastModified" => "2014-01-08T00:02:40Z"
        ];
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @covers \Jsdecena\Payjunction\Services\Transactions\Receipts\TransactionReceiptService
     */
    public function it_should_get_all_transaction_receipts()
    {
        // Show all transaction receipts
        $transactionReceipts = $this->transactionReceiptService->all();
        $transactionReceiptsDecode = json_decode($transactionReceipts->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([$this->transactionReceiptMock()]), json_encode($transactionReceiptsDecode));
        $this->assertSame(200, $transactionReceipts->getStatusCode());
    }
}
