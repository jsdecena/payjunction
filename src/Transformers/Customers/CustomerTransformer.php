<?php

namespace Jsdecena\Payjunction\Transformers\Customers;

use Jsdecena\Payjunction\Models\Customers\Customer;
use League\Fractal;

class CustomerTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param Customer $customer
     *
     * @return array
     */
    public function transform(Customer $customer): array
    {
        return [
            'id' => $customer->id,
            'first_name' => $customer->firstName,
            'last_name' => $customer->lastName,
            'created_at' => $customer->createdAt,
            'updated_at' => $customer->updatedAt,
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => $customer->uri,
                ]
            ],
        ];
    }
}
