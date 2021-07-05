# Payjunction

[![master](https://github.com/jsdecena/payjunction/actions/workflows/master.yml/badge.svg?branch=master)](https://github.com/jsdecena/payjunction/actions/workflows/master.yml)

Fully tested, un-official [Payjunction](https://www.payjunction.com) SDK for PHP (WIP)

# Requirements
PHP >= v7.3

# Install

```bash
composer require jsdecena/payjunction
```

# Usage

## Customers

```php
use Jsdecena\Payjunction\Services\Customers\CustomerService;
use Jsdecena\Payjunction\Services\PayjunctionService;

$service = new PayjunctionService('<your-username>', '<your-password>', '<your-app-key>');
$customerService = new CustomerService($service);

// === CRUD
$customerService->all(); ### Get all customers
$customerService->store(['firstName' => 'John', 'lastName' => 'Doe']); ### create customer
$customerService->show(1); ### show customer
$customerService->update(1, ['firstName' => 'Jane', 'lastName' => 'Doe']); ### update customer
$customerService->delete(1); ### delete customer
```

