<?php

namespace Jsdecena\Payjunction\Tests\Customers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\Customers\CustomerService;
use Jsdecena\Payjunction\Services\PayjunctionService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class CustomerTest extends BaseTestCase
{
    private $customerService;

    public function setUp(): void
    {
        parent::setUp();

        $handlerStack = HandlerStack::create($this->mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new PayjunctionService('test', 'test', 'test', false, $client);
        $this->customerService = new CustomerService($service);
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
            new Response(200, [], json_encode($this->allCustomersMock())), // All customers
            new Response(201, [], json_encode($this->customerMock())), // Create customer
            new Response(200, [], json_encode($this->customerMock())), // Show customer
            new Response(200, [], json_encode($this->customerMock())), // Update customer
            new Response(202, [], json_encode([])) // Delete
        ];
    }

    /**
     * @return array
     */
    private function allCustomersMock(): array
    {
        return [
            [
                'customerId' => 1,
                'uri' => 'https://api.payjunctionlabs.com/customers/1',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'created' => '2021-07-01T17:44:46Z',
                'lastModified' => '2021-07-01T17:44:46Z'
            ],
            [
                'customerId' => 2,
                'uri' => 'https://api.payjunctionlabs.com/customers/2',
                'firstName' => 'Jane',
                'lastName' => 'Doe',
                'created' => '2021-07-01T17:44:46Z',
                'lastModified' => '2021-07-01T17:44:46Z'
            ]
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
            'lastName' => 'Doe',
            'created' => '2021-07-01T17:44:46Z',
            'lastModified' => '2021-07-01T17:44:46Z'
        ];
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function it_should_perform_customer_crud()
    {
        // Show all customers
        $showCustomers = $this->customerService->all();
        $decode1 = json_decode($showCustomers->getBody(), true);
        $this->assertJsonStringEqualsJsonString(json_encode($this->allCustomersMock()), json_encode($decode1));

        // Create customer
        $createCustomer = $this->customerService->store($this->customerMock());
        $decode2 = json_decode($createCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerMock()), json_encode($decode2));
        $this->assertSame(201, $createCustomer->getStatusCode());

        // Show customer
        $showCustomer = $this->customerService->show(1);
        $decode3 = json_decode($showCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerMock()), json_encode($decode3));
        $this->assertSame(200, $showCustomer->getStatusCode());

        // Update customer
        $updateCustomer = $this->customerService->update(1, $this->customerMock());
        $update = json_decode($updateCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerMock()), json_encode($update));
        $this->assertSame(200, $updateCustomer->getStatusCode());

        // Delete customer
        $deleteCustomer = $this->customerService->delete(1);
        $delete = json_decode($deleteCustomer->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([]), json_encode($delete));
        $this->assertSame(202, $deleteCustomer->getStatusCode());
    }
}
