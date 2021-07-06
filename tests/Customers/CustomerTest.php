<?php

namespace Jsdecena\Payjunction\Tests\Customers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\Customers\CustomerNoteService;
use Jsdecena\Payjunction\Services\Customers\CustomerService;
use Jsdecena\Payjunction\Services\PayjunctionService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class CustomerTest extends BaseTestCase
{
    private $customerService;
    private $customerNoteService;

    public function setUp(): void
    {
        parent::setUp();

        $handlerStack = HandlerStack::create($this->mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new PayjunctionService('test', 'test', 'test', false, $client);
        $this->customerService = new CustomerService($service);

        $this->customerNoteService = new CustomerNoteService(1, $service);
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
            new Response(202, [], json_encode([])), // Delete
            new Response(200, [], json_encode([$this->customerNote()])), // All customer notes
            new Response(201, [], json_encode($this->customerNote())), // Create customer note
            new Response(200, [], json_encode($this->customerNote())), // Show customer note
            new Response(200, [], json_encode($this->customerNote())), // Update customer note
            new Response(202, [], json_encode([])), // Delete
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
     * @return array
     */
    private function customerNote(): array
    {
        return [
            'noteId' => 1,
            'uri' => "https://api.payjunctionlabs.com/customers/1/notes/1",
            'note' => 'This is a note',
            'created' => '2021-07-01T17:44:46Z',
            'lastModified' => '2021-07-01T17:44:46Z'
        ];
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function it_should_perform_customer_and_customer_notes_crud()
    {
        // Show all customers
        $showCustomers = $this->customerService->all();
        $showCustomersDecode = json_decode($showCustomers->getBody(), true);
        $this->assertJsonStringEqualsJsonString(json_encode($this->allCustomersMock()), json_encode($showCustomersDecode));

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

        // Show all customer notes
        $showCustomerNotes = $this->customerNoteService->all();
        $customerNotesDecode = json_decode($showCustomerNotes->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([$this->customerNote()]), json_encode($customerNotesDecode));
        $this->assertSame(200, $showCustomerNotes->getStatusCode());

        // Create customer note
        $createCustomerNote = $this->customerNoteService->store($this->customerNote());
        $createCustomerNoteDecode = json_decode($createCustomerNote->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerNote()), json_encode($createCustomerNoteDecode));
        $this->assertSame(201, $createCustomerNote->getStatusCode());

        // Show customer note
        $showCustomerNote = $this->customerNoteService->show(1);
        $showCustomerNoteDecode = json_decode($showCustomerNote->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerNote()), json_encode($showCustomerNoteDecode));
        $this->assertSame(200, $showCustomerNote->getStatusCode());

        // Update customer note
        $updateCustomerNote = $this->customerNoteService->update(1, $this->customerNote());
        $updateCustomerNoteDecode = json_decode($updateCustomerNote->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->customerNote()), json_encode($updateCustomerNoteDecode));
        $this->assertSame(200, $showCustomerNote->getStatusCode());

        // Delete customer note
        $deleteCustomerNote = $this->customerNoteService->delete(1);
        $deleteCustomerNoteDecode = json_decode($deleteCustomerNote->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([]), json_encode($deleteCustomerNoteDecode));
        $this->assertSame(202, $deleteCustomerNote->getStatusCode());
    }
}
