<?php

namespace Jsdecena\Payjunction\Tests\Customers\Addresses;

use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\Customers\Addresses\CustomerAddressService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class CustomerAddressTest extends BaseTestCase
{
    private CustomerAddressService $customerAddressService;

    public function setUp(): void
    {
        parent::setUp();
        $this->customerAddressService = new CustomerAddressService(1, $this->service);
    }

    private function addressMock(): array
    {
        return [
            "addressId" => 875,
            "uri" => "https://api.payjunction.com/customers/1/addresses/875",
            "address" => "Piazza di Spagna 26",
            "city" => "Roma",
            "state" => "Provincia di Roma",
            "country" => "Italy",
            "zip" => "00187",
            "created" => "2013-11-19T03:29:01Z",
            "lastModified" => "2013-11-19T03:29:01Z"
        ];
    }
    public function getMockResponse(Response ...$response): array
    {
        return [
            new Response(200, [], json_encode([$this->addressMock()])), // All customer address
            new Response(201, [], json_encode($this->addressMock())), // Create customer address
            new Response(200, [], json_encode($this->addressMock())), // Show customer address
            new Response(200, [], json_encode($this->addressMock())), // Update customer address
            new Response(202, [], json_encode([])), // Delete customer address
        ];
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @covers CustomerAddressService
     */
    public function it_should_perform_customer_address_crud()
    {

        // Show all customer notes
        $showCustomerNotes = $this->customerAddressService->all();
        $customerNotesDecode = json_decode($showCustomerNotes->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([$this->addressMock()]), json_encode($customerNotesDecode));
        $this->assertSame(200, $showCustomerNotes->getStatusCode());

        // Create customer note
        $createCustomerNote = $this->customerAddressService->store($this->addressMock());
        $createCustomerNoteDecode = json_decode($createCustomerNote->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->addressMock()), json_encode($createCustomerNoteDecode));
        $this->assertSame(201, $createCustomerNote->getStatusCode());

        // Show customer note
        $showCustomerNote = $this->customerAddressService->show(1);
        $showCustomerNoteDecode = json_decode($showCustomerNote->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->addressMock()), json_encode($showCustomerNoteDecode));
        $this->assertSame(200, $showCustomerNote->getStatusCode());

        // Update customer note
        $updateCustomerNote = $this->customerAddressService->update(1, $this->addressMock());
        $updateCustomerNoteDecode = json_decode($updateCustomerNote->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->addressMock()), json_encode($updateCustomerNoteDecode));
        $this->assertSame(200, $showCustomerNote->getStatusCode());

        // Delete customer note
        $deleteCustomerNote = $this->customerAddressService->delete(1);
        $deleteCustomerNoteDecode = json_decode($deleteCustomerNote->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([]), json_encode($deleteCustomerNoteDecode));
        $this->assertSame(202, $deleteCustomerNote->getStatusCode());
    }
}
