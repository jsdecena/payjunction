<?php

namespace Jsdecena\Payjunction\Tests\Transactions;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\PayjunctionService;
use Jsdecena\Payjunction\Services\Transactions\TransactionService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class TransactionTest extends BaseTestCase
{
    protected TransactionService $transactionService;

    public function setUp(): void
    {
        parent::setUp();

        $handlerStack = HandlerStack::create($this->mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new PayjunctionService('test', 'test', 'test', false, $client);
        $this->transactionService = new TransactionService($service);
    }

    public function getMockResponse(Response ...$response): array
    {
        return [
            new Response(200, [], json_encode([$this->transactionMock()])), // All transactions
            new Response(201, [], json_encode($this->transactionMock())), // Create transaction
            new Response(200, [], json_encode($this->transactionMock())), // Show transaction
            new Response(200, [], json_encode($this->transactionMock())), // Update transaction
        ];
    }

    private function transactionMock(): array
    {
        return [
            "transactionId" => 3601,
            "uri" => "https://api.payjunction.com/transactions/3601",
            "terminalId" => 1,
            "action" => "CHARGE",
            "amountBase" => "1.00",
            "amountTax" => "1.00",
            "amountShipping" => "1.00",
            "amountTip" => "1.00",
            "amountSurcharge" => "1.00",
            "amountTotal" => "5.00",
            "custom1" => "88888888444444444444cccccccccccc",
            "invoiceId" => "6de5394f-5e3b-469e-bc19-01fcc27c2724",
            "invoiceNumber" => "Invoice 5",
            "purchaseOrderNumber" => "Custom PO",
            "method" => "KEYED",
            "service" => "QUICKSHOP",
            "status" => "CAPTURE",
            "signatureStatus" => "SIGNED",
            "created" => "2013-11-18T22:15:32Z",
            "lastModified" => "2013-11-18T22:15:32Z",
        ];
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function it_should_perform_transactions_crud()
    {
        // Show all transactions
        $showCustomers = $this->transactionService->all();
        $showCustomersDecode = json_decode($showCustomers->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([$this->transactionMock()]), json_encode($showCustomersDecode));
        $this->assertSame(200, $showCustomers->getStatusCode());

        // Create transaction
        $createCustomer = $this->transactionService->store($this->transactionMock());
        $createCustomerDecode = json_decode($createCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->transactionMock()), json_encode($createCustomerDecode));
        $this->assertSame(201, $createCustomer->getStatusCode());

        // Show transaction
        $showCustomer = $this->transactionService->show(1);
        $showCustomerDecode = json_decode($showCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->transactionMock()), json_encode($showCustomerDecode));
        $this->assertSame(200, $showCustomer->getStatusCode());

        // Update transaction
        $updateCustomer = $this->transactionService->update(1, $this->transactionMock());
        $updateCustomerDecode = json_decode($updateCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->transactionMock()), json_encode($updateCustomerDecode));
        $this->assertSame(200, $updateCustomer->getStatusCode());
    }
}
