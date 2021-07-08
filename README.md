# Payjunction

[![master](https://github.com/jsdecena/payjunction/actions/workflows/master.yml/badge.svg?branch=master)](https://github.com/jsdecena/payjunction/actions/workflows/master.yml)
[![codecov](https://codecov.io/gh/jsdecena/payjunction/branch/main/graph/badge.svg?token=MaEX5kmM8N)](https://codecov.io/gh/jsdecena/payjunction)

Fully tested, un-official [Payjunction](https://www.payjunction.com) SDK for PHP

# Requirements
PHP >= v7.3
Laravel >= 6.x
Lumen >= 6.x

# Install

```bash
composer require jsdecena/payjunction:^0.1
```

### Lumen
```
$app->register('Jsdecena\Payjunction\PayjunctionProvider');
````

# Usage

## Customers

```php
use Jsdecena\Payjunction\Services\Customers\CustomerService;
use Jsdecena\Payjunction\Services\PayjunctionService;

// If you need to make it PRODUCTION mode, set the 4th param to TRUE
$service = new PayjunctionService('<your-username>', '<your-password>', '<your-app-key>', false);
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
use Jsdecena\Payjunction\Services\Customers\Notes\CustomerNoteService;
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
use Jsdecena\Payjunction\Services\Customers\Addresses\CustomerAddressService;
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
use Jsdecena\Payjunction\Services\Transactions\Receipts\TransactionReceiptService;
use Jsdecena\Payjunction\Services\Transactions\Notes\TransactionNoteService;
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
$transactionReceiptService = new TransactionReceiptService($transactionId, $service);
$transactionReceiptService->all();

// Notes
$transactionNoteService = new TransactionNoteService($transactionId, $service);
$transactionNoteService->all();
$noteData = [
    'noteId' => 1,
    'uri' => "https://api.payjunctionlabs.com/customers/1/notes/1",
    'note' => 'This is a note',
    'created' => '2021-07-01T17:44:46Z',
    'lastModified' => '2021-07-01T17:44:46Z'
];
$transactionNoteService->store($noteData);
$noteId = 456;
$transactionNoteService->show($noteId);
$transactionNoteService->update($noteId, $noteData);
$transactionNoteService->delete($noteId);
```

## Invoices

```php
use Jsdecena\Payjunction\Services\Invoices\InvoiceService;
use Jsdecena\Payjunction\Services\PayjunctionService;
use Jsdecena\Payjunction\Services\Invoices\Actions\InvoiceVoidService;
use Jsdecena\Payjunction\Services\Invoices\Actions\InvoiceReopenService;
use Jsdecena\Payjunction\Services\Invoices\Actions\InvoiceReminderService;

$service = new PayjunctionService('<your-username>', '<your-password>', '<your-app-key>');
$invoiceService = new InvoiceService($service);

$invoiceService->all(); ### Get all customer invoices
$invoiceData = [
    "amountBase" => "1.99",
    "customerEmail" => "jdoe@payjunction.com",
    "customerFirstName" => "John",
    "customerIdentifier" => "customer-id",
    "customerLastName" => "Doe",
    "invoiceId" => "e321790e-c030-4501-aa99-09e35158c1a6",
    "invoiceNumber" => "TO-123456",
    "message" => "Invoice for takeout order #123456",
    "terminalId" => 1
];
$invoiceService->store($invoiceData); ### create customer invoice

$invoiceId = 1;
$invoiceService->show($invoiceId); ### show customer invoice

## VOID
$invoiceService = new InvoiceVoidService($invoiceId, $service);
$invoiceService->void();

## REOPEN
$invoiceService = new InvoiceReopenService($invoiceId, $service);
$invoiceService->reopen();

## SEND EMAIL REMINDER
$invoiceService = new InvoiceReminderService($invoiceId, $service);
$invoiceService->send();
```
