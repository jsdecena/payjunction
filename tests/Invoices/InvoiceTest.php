<?php

namespace Jsdecena\Payjunction\Tests\Invoices;

use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\Invoices\InvoiceService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class InvoiceTest extends BaseTestCase
{
    protected InvoiceService $invoiceService;

    public function setUp(): void
    {
        parent::setUp();
        $this->invoiceService = new InvoiceService($this->service);
    }

    public function getMockResponse(Response ...$response): array
    {
        return [
            new Response(200, [], json_encode([$this->invoiceMock()])), // All invoices
            new Response(201, [], json_encode($this->invoiceMock())), // Create invoice
            new Response(200, [], json_encode($this->invoiceMock())), // Show invoice
            new Response(201, [], json_encode($this->invoiceMock())), // Void invoice
            new Response(201, [], json_encode($this->invoiceMock())), // Reopen invoice
            new Response(201, [], json_encode($this->invoiceMock())), // Send-reminder invoice
            new Response(201, [], json_encode($this->invoiceMock())), // Send file invoice
        ];
    }

    private function invoiceMock(): array
    {
        return [
            "amountBase" => "1.99",
            "created" => "2020-11-24T01:19:23Z",
            "customerEmail" => "jdoe@payjunction.com",
            "customerFirstName" => "John",
            "customerIdentifier" => "customer-id",
            "customerLastName" => "Doe",
            "invoiceId" => "e321790e-c030-4501-aa99-09e35158c1a6",
            "invoiceNumber" => "TO-123456",
            "lastModified" => "2020-11-24T01:19:23Z",
            "message" => "Invoice for takeout order #123456",
            "status" => "OPEN",
            "terminalId" => 1
        ];
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @covers InvoiceService::all
     */
    public function it_should_perform_invoice_crud()
    {
        // Show all invoices
        $invoices = $this->invoiceService->all();
        $invoicesDecode = json_decode($invoices->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([$this->invoiceMock()]), json_encode($invoicesDecode));
        $this->assertSame(200, $invoices->getStatusCode());

        // Create invoice
        $createCustomer = $this->invoiceService->store($this->invoiceMock());
        $createCustomerDecode = json_decode($createCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->invoiceMock()), json_encode($createCustomerDecode));
        $this->assertSame(201, $createCustomer->getStatusCode());

        // Show invoice
        $createCustomer = $this->invoiceService->show(1);
        $createCustomerDecode = json_decode($createCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->invoiceMock()), json_encode($createCustomerDecode));
        $this->assertSame(200, $createCustomer->getStatusCode());
    }
}
