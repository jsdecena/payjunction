<?php

namespace Jsdecena\Payjunction\Services\SmartTerminals;

use Jsdecena\Payjunction\Services\PayjunctionService;

class SmartTerminalService
{
    /**
     * @var PayjunctionService $service
     */
    protected PayjunctionService $service;

    private int $terminalId;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/218162118-POST-smartterminals-smartTerminalId-request-payment
     */

    /** @var string $endpoint */
    protected string $endpoint = '/smartterminals';

    public function __construct(int $terminalId, PayjunctionService $service)
    {
        $this->terminalId = $terminalId;
        $this->service = $service;
    }

    /**
     * Get smart terminals
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSmartTerminals(): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . $this->endpoint);
    }

    /**
     * Get terminals
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTerminals(): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . '/terminals');
    }

    /**
     * Request for payment
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestPayment(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . $this->endpoint . "/$this->terminalId/request-payment", [
            'form_params' => $data
        ]);
    }

    /**
     * Request for signature
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestSignature(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . $this->endpoint . "/$this->terminalId/request-signature", [
            'form_params' => $data
        ]);
    }

    /**
     * Request for prompt
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestPrompt(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . $this->endpoint . "/$this->terminalId/request-prompt", [
            'form_params' => $data
        ]);
    }

    /**
     * Request for payment
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function main(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . $this->endpoint . "/$this->terminalId/main", [
            'form_params' => $data
        ]);
    }

    /**
     * Get request
     *
     * @param int $requestId
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRequests(int $requestId): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . $this->endpoint . "/requests/$requestId");
    }

    /**
     * Get signature
     *
     * @param int $signatureId
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSignatures(int $signatureId): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . $this->endpoint . "/signatures/$signatureId/image");
    }
}
