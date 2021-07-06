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

$customerService->all(); ### Get all customers
$customerService->store(['firstName' => 'John', 'lastName' => 'Doe']); ### create customer
$customerService->show(1); ### show customer
$customerService->update(1, ['firstName' => 'Jane', 'lastName' => 'Doe']); ### update customer
$customerService->delete(1); ### delete customer

// === Get response body
$all = $customerService->all();
// As an array
json_decode($all->getBody(), true);
// Or as an object
json_decode($all->getBody());
```

## Customer notes

```php
use Jsdecena\Payjunction\Services\Customers\CustomerNoteService;
use Jsdecena\Payjunction\Services\PayjunctionService;

$service = new PayjunctionService('<your-username>', '<your-password>', '<your-app-key>');
$customerId = 123;
$customerNoteService = new CustomerNoteService($customerId, $service);

$customerNoteService->all(); ### Get all customer notes
$note = ['note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer imperdiet purus vel molestie cursus. Pellentesque condimentum leo ut rutrum tincidunt. '];
$customerNoteService->store($note); ### create customer note
$customerNoteService->show(1); ### show customer note
$customerNoteService->update(1, ['note' => 'Foo bar']); ### update customer note
$customerNoteService->delete(1); ### delete customer note
```

## Customer addresses

```php
use Jsdecena\Payjunction\Services\Customers\CustomerAddressService;
use Jsdecena\Payjunction\Services\PayjunctionService;

$service = new PayjunctionService('<your-username>', '<your-password>', '<your-app-key>');
$customerId = 123;
$customerAddressService = new CustomerAddressService($customerId, $service);

$customerAddressService->all(); ### Get all customer addresses
$address = [
    "address" => "Piazza di Spagna 26",
    "city" => "Roma",
    "state" => "Provincia di Roma",
    "country" => "Italy",
    "zip" => "00187",
];
$customerAddressService->store($address); ### create customer address
$customerAddressService->show(1); ### show customer address
$customerAddressService->update(1, ['address' => 'Foo bar']); ### update customer address
$customerAddressService->delete(1); ### delete customer address
```

## Transactions

```php
use Jsdecena\Payjunction\Services\Transactions\TransactionService;
use Jsdecena\Payjunction\Services\PayjunctionService;

$service = new PayjunctionService('<your-username>', '<your-password>', '<your-app-key>');
$transactionService = new TransactionService($service);

$transactionService->all(); ### Get all transactions
$data = [
    'cardNumber' => '4444333322221111',
    'cardExpMonth' => '01',
    'cardExpYear' => '18',
    'cardCvv' => '999',
    'amountBase' => '10.00'
];
$transactionService->store($data); ### create transaction
$transactionService->show(1); ### show customer transaction
$transactionService->update(1, ['address' => 'Foo bar']); ### update customer transaction

// Get the receipt
$transactionId = 123;
$transactionService->showReceipts($transactionId);
```

