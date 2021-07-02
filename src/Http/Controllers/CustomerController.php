<?php

namespace Jsdecena\Payjunction\Http\Controllers;

use App\Http\Controllers\Controller;
use Jsdecena\Payjunction\Exceptions\CustomerNotFoundException;
use Jsdecena\Payjunction\Services\Customers\CustomerService;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customers)
    {
        $this->customerService = $customers;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return response()->json(['data' => $this->customerService->delete(11)]);
        } catch (CustomerNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
