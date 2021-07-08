<?php

namespace Jsdecena\Payjunction\Services\Customers\Notes;

use Jsdecena\Payjunction\Services\Customers\BaseCustomerService;
use Jsdecena\Payjunction\Services\Customers\Notes\Exceptions\CustomerNoteException;
use Jsdecena\Payjunction\Services\PayjunctionService;

class CustomerNoteService extends BaseCustomerService
{
    private PayjunctionService $service;

    private int $customerId;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/216543507-POST-customers-customerId-notes
     */

    /** @var string $endpoint */
    private string $noteEndpoint = 'notes';

    public function __construct(int $customerId, PayjunctionService $service)
    {
        $this->customerId = $customerId;
        $this->service = $service;
    }

    /**
     * Build the URL endpoint
     *
     * @param int|null $noteId
     *
     * @return string
     */
    public function buildUrl(int $noteId = null): string
    {
        $endpoint = $this->endpoint . "/$this->customerId/$this->noteEndpoint";
        if ($noteId) {
            $endpoint .= "/$noteId";
        }
        return $endpoint;
    }

    /**
     * Get all the customer's notes
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(array $queryParams = ['limit' => 50, 'offset' => 0]): \Psr\Http\Message\ResponseInterface
    {
        $buildUrl = $this->buildUrl() . '?' . http_build_query($queryParams);
        $query = $this->service->host . $buildUrl;

        return $this
            ->service
            ->http
            ->get($query, $this->service->headers);
    }

    /**
     * Create a customer note
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws CustomerNoteException
     */
    public function store(array $data): \Psr\Http\Message\ResponseInterface
    {
        $rules = [
            'note' => ['required']
        ];

        $validator = $this->service->validate($data, $rules);

        if (!empty($validator)) {
            throw new CustomerNoteException(json_encode($validator));
        }
        return $this->service->http->post($this->service->host . $this->buildUrl(), [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific customer note
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(int $id): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . $this->buildUrl($id));
    }

    /**
     * Update the information of a specific customer note
     *
     * @param int $id
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->put($this->service->host . $this->buildUrl($id), [
            'form_params' => $data
        ]);
    }

    /**
     * Delete the information of a specific customer note
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $id): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->delete($this->service->host . $this->buildUrl($id));
    }
}
