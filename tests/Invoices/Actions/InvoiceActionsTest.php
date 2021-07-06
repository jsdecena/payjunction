<?php

namespace Jsdecena\Payjunction\Tests\Invoices;

use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\Invoices\Actions\InvoiceReminderService;
use Jsdecena\Payjunction\Services\Invoices\Actions\InvoiceReopenService;
use Jsdecena\Payjunction\Services\Invoices\Actions\InvoiceVoidService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class InvoiceActionsTest extends BaseTestCase
{
    private InvoiceVoidService $invoiceVoidService;
    private InvoiceReopenService $invoiceReopenService;
    private InvoiceReminderService $invoiceReminderService;

    public function setUp(): void
    {
        parent::setUp();
        $this->invoiceVoidService = new InvoiceVoidService(1, $this->service);
        $this->invoiceReopenService = new InvoiceReopenService(1, $this->service);
        $this->invoiceReminderService = new InvoiceReminderService(1, $this->service);
    }

    public function getMockResponse(Response ...$response): array
    {
        return [
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
     */
    public function it_should_perform_invoice_actions()
    {
        // Void invoice
        $void = $this->invoiceVoidService->void();
        $voidDecoded = json_decode($void->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->invoiceMock()), json_encode($voidDecoded));
        $this->assertSame(201, $void->getStatusCode());

        // Reopen invoice
        $reopen = $this->invoiceReopenService->reopen();
        $reopenDecode = json_decode($reopen->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->invoiceMock()), json_encode($reopenDecode));
        $this->assertSame(201, $reopen->getStatusCode());

        // Send email reminder
        $createCustomer = $this->invoiceReminderService->send();
        $createCustomerDecode = json_decode($createCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->invoiceMock()), json_encode($createCustomerDecode));
        $this->assertSame(201, $createCustomer->getStatusCode());
    }
}
