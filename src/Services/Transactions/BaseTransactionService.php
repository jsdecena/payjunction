<?php

namespace Jsdecena\Payjunction\Services\Transactions;

abstract class BaseTransactionService
{
    /** @var string $endpoint */
    protected string $endpoint = '/transactions';
}
