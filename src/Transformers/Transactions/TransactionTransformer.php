<?php

namespace Jsdecena\Payjunction\Transformers\Transactions;

use League\Fractal;

class TransactionTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function transform(array $data): array
    {
        return [
            'id' => (int)$data['transactionId'],
            'terminal_id' => $data['terminalId'],
            'action' => $data['action'],
            'amount_base' => $data['amountBase'],
            'amount_tax' => $data['amountTax'],
            'amount_shipping' => $data['amountShipping'],
            'amount_tip' => $data['amountTip'],
            'amount_surcharge' => $data['amountSurcharge'],
            'amount_total' => $data['amountTotal'],
            'custom' => $data['custom1'],
            'invoice_id' => $data['invoiceId'],
            'invoice_number' => $data['invoiceNumber'],
            'purchase_order_number' => $data['purchaseOrderNumber'],
            'method' => $data['method'],
            'service' => $data['service'],
            'status' => $data['status'],
            'signatureStatus' => $data['signatureStatus'],
            'created_at' => $data['created'],
            'updated_at' => $data['lastModified'],
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => $data['uri'],
                ]
            ],
        ];
    }
}
