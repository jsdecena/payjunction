<?php

namespace Jsdecena\Payjunction\Tests\Customers\Notes;

use GuzzleHttp\Psr7\Response;
use Jsdecena\Payjunction\Services\Customers\Notes\CustomerNoteService;
use Jsdecena\Payjunction\Tests\BaseTestCase;

class CustomerNoteTest extends BaseTestCase
{
    private CustomerNoteService $customerNoteService;

    public function setUp(): void
    {
        parent::setUp();
        $this->customerNoteService = new CustomerNoteService(1, $this->service);
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

    public function getMockResponse(Response ...$response): array
    {
        return [
            new Response(200, [], json_encode([$this->customerNote()])), // All customer notes
            new Response(201, [], json_encode($this->customerNote())), // Create customer note
            new Response(200, [], json_encode($this->customerNote())), // Show customer note
            new Response(200, [], json_encode($this->customerNote())), // Update customer note
            new Response(202, [], json_encode([])), // Delete
        ];
    }

    /** @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @covers CustomerNoteService::all
     */
    public function it_should_perform_customer_notes_crud()
    {

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
