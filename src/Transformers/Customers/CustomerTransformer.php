<?php

namespace Jsdecena\Payjunction\Transformers\Customers;

use League\Fractal;

class CustomerTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function transform(array $data): array
    {
        return [
            'id' => (int)$data['customerId'],
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'created_at' => $data['created'],
            'updated_at' => $data['lastModified'],
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/customers/' . $data['customerId'],
                ]
            ],
        ];
    }
}
