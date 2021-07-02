<?php

namespace Jsdecena\Payjunction\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Jsdecena\Payjunction\Services\Customers\CustomerService;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customers)
    {
        $this->customerService = $customers;
    }

    /**
     * @throws GuzzleException
     */
    public function index()
    {
        return response()->json(['data' => $this->customerService->all()]);
    }
}
