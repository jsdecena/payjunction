<?php

namespace Jsdecena\Payjunction\Tests\Transactions\Notes;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\PayjunctionService;
use Jsdecena\Payjunction\Services\Transactions\Notes\TransactionNoteService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class TransactionNoteTest extends BaseTestCase
{
    private TransactionNoteService $transactionNoteService;

    public function setUp(): void
    {
        parent::setUp();

        $handlerStack = HandlerStack::create($this->mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new PayjunctionService('test', 'test', 'test', false, $client);
        $this->transactionNoteService = new TransactionNoteService($service);
    }

    public function getMockResponse(Response ...$response): array
    {
        return [
            new Response(200, [], json_encode([$this->transactionNoteMock()])), // All transaction notes
            new Response(200, [], json_encode($this->transactionNoteMock())), // Transaction note
            new Response(200, [], json_encode($this->transactionNoteMock())), // Update Transaction note
            new Response(201, [], json_encode($this->transactionNoteMock())), // Create Transaction note
            new Response(202, [], json_encode([])), // Delete
        ];
    }

    private function transactionNoteMock(): array
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function it_should_perform_transaction_notes_crud()
    {
        // Show all transaction notes
        $transactionReceipts = $this->transactionNoteService->allNotes(1);
        $transactionReceiptsDecode = json_decode($transactionReceipts->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([$this->transactionNoteMock()]), json_encode($transactionReceiptsDecode));
        $this->assertSame(200, $transactionReceipts->getStatusCode());

        // Note
        $transactionReceipts = $this->transactionNoteService->showNote(1, 1);
        $transactionReceiptsDecode = json_decode($transactionReceipts->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->transactionNoteMock()), json_encode($transactionReceiptsDecode));
        $this->assertSame(200, $transactionReceipts->getStatusCode());

        // Note update
        $transactionReceipts = $this->transactionNoteService->updateNote(1, 1, $this->transactionNoteMock());
        $transactionReceiptsDecode = json_decode($transactionReceipts->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->transactionNoteMock()), json_encode($transactionReceiptsDecode));
        $this->assertSame(200, $transactionReceipts->getStatusCode());

        // Note create
        $transactionReceipts = $this->transactionNoteService->storeNote(1, $this->transactionNoteMock());
        $transactionReceiptsDecode = json_decode($transactionReceipts->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode($this->transactionNoteMock()), json_encode($transactionReceiptsDecode));
        $this->assertSame(201, $transactionReceipts->getStatusCode());

        // Note delete
        $transactionReceipts = $this->transactionNoteService->deleteNote(1, 1);
        $transactionReceiptsDecode = json_decode($transactionReceipts->getBody(), true);

        $this->assertJsonStringEqualsJsonString(json_encode([]), json_encode($transactionReceiptsDecode));
        $this->assertSame(202, $transactionReceipts->getStatusCode());
    }
}
