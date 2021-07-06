<?php

namespace Jsdecena\Payjunction\Services\Transactions\Notes;

use Jsdecena\Payjunction\Services\Transactions\TransactionService;

class TransactionNoteService extends TransactionService
{
    private string $noteEndpoint = 'notes';

    /**
     * @param int $transactionId
     * @param string $type eg. latest|thermal|fullpage
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function allNotes(int $transactionId, string $type = 'latest'): \Psr\Http\Message\ResponseInterface
    {
        $query = $this->service->host . $this->endpoint . "/$transactionId/$this->noteEndpoint";

        return $this
            ->service
            ->http
            ->get($query, $this->service->headers);
    }

    /**
     * Create a transaction
     *
     * @param int $transactionId
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function storeNote(int $transactionId, array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->post($this->service->host . $this->endpoint . "/$transactionId/$this->noteEndpoint", [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific transaction note
     *
     * @param int $transactionId
     * @param int $noteId
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showNote(int $transactionId, int $noteId): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->get($this->service->host . $this->endpoint . "/$transactionId/$this->noteEndpoint/$noteId");
    }

    /**
     * Get the information of a specific transaction note
     *
     * @param int $transactionId
     * @param int $noteId
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateNote(int $transactionId, int $noteId, array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->put($this->service->host . "/$transactionId/$this->noteEndpoint/$noteId", [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific transaction note
     *
     * @param int $transactionId
     * @param int $noteId
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteNote(int $transactionId, int $noteId): \Psr\Http\Message\ResponseInterface
    {
        return $this->service->http->delete($this->service->host . $this->endpoint . "/$transactionId/$this->noteEndpoint/$noteId");
    }
}
