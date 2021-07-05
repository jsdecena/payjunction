<?php

namespace Jsdecena\Payjunction\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected $mock;

    /**
     * Set up
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = new MockHandler($this->getMockResponse());
    }

    public abstract function getMockResponse(Response ... $response): array;
}