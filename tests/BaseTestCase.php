<?php

namespace Jsdecena\Payjunction\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\PayjunctionService;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected PayjunctionService $service;

    /**
     * Set up
     */
    protected function setUp(): void
    {
        parent::setUp();

        $mock = new MockHandler($this->getMockResponse());
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->service = new PayjunctionService('test', 'test', 'test', false, $client);
    }

    /**
     * @param Response ...$response
     *
     * @return array
     */
    public abstract function getMockResponse(Response ... $response): array;
}
