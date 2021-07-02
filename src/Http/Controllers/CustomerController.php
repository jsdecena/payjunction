<?php

namespace Jsdecena\Payjunction\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Jsdecena\Payjunction\Services\Customers\CustomerService;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customers)
    {
        $this->customerService = $customers;
    }

    /**
     * @return JsonResponse
     *
     * @throws GuzzleException
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->customerService->all()]);
    }
}
