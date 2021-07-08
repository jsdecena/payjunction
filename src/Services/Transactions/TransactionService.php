<?php

namespace Jsdecena\Payjunction\Services\Transactions;

use Jsdecena\Payjunction\Interfaces\ServiceInterface;
use Jsdecena\Payjunction\Models\Transactions\Transaction;
use Jsdecena\Payjunction\Services\PayjunctionService;
use Jsdecena\Payjunction\Transformers\Transactions\TransactionTransformer;

class TransactionService implements ServiceInterface
{
    /**
     * @var PayjunctionService $service
     */
    protected PayjunctionService $service;

    private TransactionTransformer $transformer;

    protected \Psr\Http\Message\ResponseInterface $data;

    /**
     * API Docs
     * @url https://developer.payjunction.com/hc/en-us/articles/216477437-GET-transactions-transactionId-
     */

    /** @var string $endpoint */
    protected string $endpoint = '/transactions';

    public function __construct(PayjunctionService $service)
    {
        $this->service = $service;
        $this->transformer = new TransactionTransformer();
    }

    /**
     * Get all the customers
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(array $queryParams = ['limit' => 50, 'offset' => 0]): \Psr\Http\Message\ResponseInterface
    {
        $query = $this->service->host . $this->endpoint . '?' . http_build_query($queryParams);

        return $this->data =  $this
            ->service
            ->http
            ->get($query, $this->service->headers);
    }

    /**
     * Create a transaction
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->data =  $this->service->http->post($this->service->host . $this->endpoint, [
            'form_params' => $data
        ]);
    }

    /**
     * Get the information of a specific transaction
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(int $id): \Psr\Http\Message\ResponseInterface
    {
        return $this->data =  $this->service->http->get($this->service->host . $this->endpoint . '/' . $id);
    }

    /**
     * Get the information of a specific transaction
     *
     * @param int $id
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, array $data): \Psr\Http\Message\ResponseInterface
    {
        return $this->data =  $this->service->http->put($this->service->host . $this->endpoint . '/' . $id, [
            'form_params' => $data
        ]);
    }

    /**
     * @return array
     */
    public function transform(): array
    {
        return $this->transformer->transform(new Transaction(json_decode($this->data->getBody(), true)));
    }

    /**
     * @return array
     */
    public function toCollection(): array
    {
        $items = json_decode($this->data->getBody(), true);
        $collection = [];
        foreach ($items['results'] as $item) {
            $collection[] = $this->transformer->transform(new Transaction($item));
        }
        return $collection;
    }
}
