<?php

namespace Jsdecena\Payjunction\Models\Transactions;

class Transaction
{
    public int $id;

    public int $terminalId;

    public string $action;

    public string $amountBase;

    public string $amountTax;

    public string $amountShipping;

    public string $amountTip;

    public string $amountSurcharge;

    public string $amountTotal;

    public string $custom;

    public string $invoiceId;

    public string $invoiceNumber;

    public string $purchaseOrderNumber;

    public string $method;

    public string $service;

    public string $status;

    public string $signatureStatus;

    public string $createdAt;

    public string $updatedAt;

    public string $uri;

    public function __construct(array $data)
    {
        $this->id = $data['transactionId'];
        $this->terminalId = $data['terminalId'];
        $this->action = $data['action'];
        $this->amountBase = $data['amountBase'];
        $this->amountTax = $data['amountTax'];
        $this->amountShipping = $data['amountShipping'];
        $this->amountTip = $data['amountTip'];
        $this->amountSurcharge = $data['amountSurcharge'];
        $this->amountTotal = $data['amountTotal'];
        $this->custom = $data['custom1'];
        $this->invoiceId = $data['invoiceId'];
        $this->invoiceNumber = $data['invoiceNumber'];
        $this->purchaseOrderNumber = $data['purchaseOrderNumber'];
        $this->method = $data['method'];
        $this->service = $data['service'];
        $this->status = $data['status'];
        $this->signatureStatus = $data['signatureStatus'];
        $this->createdAt = $data['created'];
        $this->updatedAt = $data['lastModified'];
        $this->uri = $data['uri'];
    }
}
