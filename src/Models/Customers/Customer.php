<?php

namespace Jsdecena\Payjunction\Models\Customers;

class Customer
{
    public int $id;

    public string $firstName;

    public string $lastName;

    public string $createdAt;

    public string $updatedAt;

    public string $uri;

    public function __construct(array $data)
    {
        $this->id = $data['customerId'];
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->uri = $data['uri'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['lastModified'];
    }

}
