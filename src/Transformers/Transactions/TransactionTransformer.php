<?php

namespace Jsdecena\Payjunction\Transformers\Transactions;

use Jsdecena\Payjunction\Models\Transactions\Transaction;
use League\Fractal;

class TransactionTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param Transaction $transaction
     *
     * @return array
     */
    public function transform(Transaction $transaction): array
    {
        return [
            'id' => $transaction->id,
            'terminal_id' => $transaction->terminalId,
            'action' => $transaction->action,
            'amount_base' => $transaction->amountBase,
            'amount_tax' => $transaction->amountTax,
            'amount_shipping' => $transaction->amountShipping,
            'amount_tip' => $transaction->amountTip,
            'amount_surcharge' => $transaction->amountSurcharge,
            'amount_total' => $transaction->amountTotal,
            'custom' => $transaction->custom,
            'invoice_id' => $transaction->invoiceId,
            'invoice_number' => $transaction->invoiceNumber,
            'purchase_order_number' => $transaction->purchaseOrderNumber,
            'method' => $transaction->method,
            'service' => $transaction->service,
            'status' => $transaction->status,
            'signatureStatus' => $transaction->signatureStatus,
            'created_at' => $transaction->createdAt,
            'updated_at' => $transaction->updatedAt,
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => $transaction->uri,
                ]
            ],
        ];
    }
}
