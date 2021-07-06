<?php

namespace Jsdecena\Payjunction\Tests\SmartTerminals;

use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\SmartTerminals\SmartTerminalService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class SmartTerminalTest extends BaseTestCase
{
    protected SmartTerminalService $smartTerminalService;

    public function setUp(): void
    {
        parent::setUp();
        $this->smartTerminalService = new SmartTerminalService(1, $this->service);
    }

    public function getMockResponse(Response ...$response): array
    {
        return [
            new Response(200, [], json_encode($this->smartTerminalMockResponse())), // Request payment
            new Response(200, [], json_encode($this->smartTerminalMockResponse())), // Request signature
            new Response(200, [], json_encode($this->smartTerminalMockResponse())), // Request prompt
            new Response(200, [], json_encode($this->smartTerminalMockResponse())), // Main
            new Response(200, [], json_encode($this->smartTerminalMockResponse())), // Get requests
            new Response(200, [], json_encode($this->smartTerminalMockResponse())), // Get signature
            new Response(200, [], json_encode($this->smartTerminalMockResponse())), // Get smart terminals
            new Response(200, [], json_encode($this->smartTerminalMockResponse())), // Get terminals
        ];
    }

    private function smartTerminalMockRequest(): array
    {
        return [
            "amountBase" => "1.00",
            "terminalId"  => "123456",
            "invoiceNumber" => "654321",
            "showReceiptPrompt" => "true",
        ];
    }

    private function smartTerminalMockResponse(): array
    {
        return [
            "requestPaymentId" => "422900dc-25bb-4b56-94f4-d7f5c9646e54"
        ];
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function it_should_perform_smart_terminal_operations()
    {
        // Request Payment
        $requestPayment = $this->smartTerminalService->requestPayment($this->smartTerminalMockRequest());
        $requestPaymentDecode = json_decode($requestPayment->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->smartTerminalMockResponse()), json_encode($requestPaymentDecode));
        $this->assertSame(200, $requestPayment->getStatusCode());

        // Request Signature
        $requestPayment = $this->smartTerminalService->requestSignature($this->smartTerminalMockRequest());
        $requestPaymentDecode = json_decode($requestPayment->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->smartTerminalMockResponse()), json_encode($requestPaymentDecode));
        $this->assertSame(200, $requestPayment->getStatusCode());

        // Request Prompt
        $requestPayment = $this->smartTerminalService->requestPrompt($this->smartTerminalMockRequest());
        $requestPaymentDecode = json_decode($requestPayment->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->smartTerminalMockResponse()), json_encode($requestPaymentDecode));
        $this->assertSame(200, $requestPayment->getStatusCode());

        // Request main
        $requestPayment = $this->smartTerminalService->main($this->smartTerminalMockRequest());
        $requestPaymentDecode = json_decode($requestPayment->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->smartTerminalMockResponse()), json_encode($requestPaymentDecode));
        $this->assertSame(200, $requestPayment->getStatusCode());

        // Get requests
        $requestPayment = $this->smartTerminalService->getRequests(1);
        $requestPaymentDecode = json_decode($requestPayment->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->smartTerminalMockResponse()), json_encode($requestPaymentDecode));
        $this->assertSame(200, $requestPayment->getStatusCode());

        // Get signatures
        $requestPayment = $this->smartTerminalService->getSignatures(1);
        $requestPaymentDecode = json_decode($requestPayment->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->smartTerminalMockResponse()), json_encode($requestPaymentDecode));
        $this->assertSame(200, $requestPayment->getStatusCode());

        // Get smart terminals
        $requestPayment = $this->smartTerminalService->getSmartTerminals();
        $requestPaymentDecode = json_decode($requestPayment->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->smartTerminalMockResponse()), json_encode($requestPaymentDecode));
        $this->assertSame(200, $requestPayment->getStatusCode());

        // Get terminals
        $requestPayment = $this->smartTerminalService->getTerminals();
        $requestPaymentDecode = json_decode($requestPayment->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->smartTerminalMockResponse()), json_encode($requestPaymentDecode));
        $this->assertSame(200, $requestPayment->getStatusCode());
    }
}
