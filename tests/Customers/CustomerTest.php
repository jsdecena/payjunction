<?php

namespace Jsdecena\Payjunction\Tests\Customers;

use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\Customers\CustomerService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class CustomerTest extends BaseTestCase
{
    private CustomerService $customerService;

    public function setUp(): void
    {
        parent::setUp();
        $this->customerService = new CustomerService($this->service);
    }

    /**
     * Mock the HTTP Response
     *
     * @param Response ...$response
     *
     * @return Response[]
     */
    public function getMockResponse(Response ...$response): array
    {
        return [
            new Response(200, [], json_encode([$this->customerMock()])), // All customers
            new Response(201, [], json_encode($this->customerMock())), // Create customer
            new Response(200, [], json_encode($this->customerMock())), // Show customer
            new Response(200, [], json_encode($this->customerMock())), // Update customer
            new Response(202, [], json_encode([])), // Delete
        ];
    }

    /**
     * @return array
     */
    private function customerMock(): array
    {
        return [
            'customerId' => 1,
            'uri' => 'https://api.payjunctionlabs.com/customers/1',
            'firstName' => 'John',
            'email' => 'john@doe.com',
            'lastName' => 'Doe',
            'created' => '2021-07-01T17:44:46Z',
            'lastModified' => '2021-07-01T17:44:46Z'
        ];
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Jsdecena\Payjunction\Services\Customers\Exceptions\CustomerException
     * @coversNothing \Jsdecena\Payjunction\Services\Customers\CustomerService
     * @covers \Jsdecena\Payjunction\Services\BaseService
     */
    public function it_should_perform_customer_crud()
    {
        // Show all customers
        $showCustomers = $this->customerService->all();
        $showCustomersDecode = json_decode($showCustomers->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([$this->customerMock()]), json_encode($showCustomersDecode));
        $this->assertSame(200, $showCustomers->getStatusCode());

        // Create customer
        $createCustomer = $this->customerService->store($this->customerMock());
        $createCustomerDecode = json_decode($createCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerMock()), json_encode($createCustomerDecode));
        $this->assertSame(201, $createCustomer->getStatusCode());

        // Show customer
        $showCustomer = $this->customerService->show(1);
        $showCustomerDecode = json_decode($showCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerMock()), json_encode($showCustomerDecode));
        $this->assertSame(200, $showCustomer->getStatusCode());

        // Update customer
        $updateCustomer = $this->customerService->update(1, $this->customerMock());
        $updateCustomerDecode = json_decode($updateCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerMock()), json_encode($updateCustomerDecode));
        $this->assertSame(200, $updateCustomer->getStatusCode());

        // Delete customer
        $deleteCustomer = $this->customerService->delete(1);
        $deleteCustomerDecode = json_decode($deleteCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([]), json_encode($deleteCustomerDecode));
        $this->assertSame(202, $deleteCustomer->getStatusCode());
    }
}
