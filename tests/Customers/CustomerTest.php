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
            new Response(200, [], $this->allCustomersMock()), // All customers

            new Response(201, [], json_encode([
                'customerId' => 1,
                'uri' => 'https://api.payjunctionlabs.com/customers/1',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'created' => '2021-07-01T17:44:46Z',
                'lastModified' => '2021-07-01T17:44:46Z'
            ])), // Create customer

            new Response(202, [], json_encode([])) // Delete
        ];
    }

    private function allCustomersMock()
    {
        return json_encode(['results' => [
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
        ]]);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function it_should_return_all_customers()
    {
        $handlerStack = HandlerStack::create($this->mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new PayjunctionService('test', 'test', 'test', false, $client);
        $customerService = new CustomerService($service);
        $all = $customerService->all();

        $this->assertJson($this->allCustomersMock(), json_encode($all));
    }
}
