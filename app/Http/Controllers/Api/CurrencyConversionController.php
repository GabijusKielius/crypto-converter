<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyConversionRequest;
use App\Services\CurrencyConversionService;
use Exception;
use Illuminate\Http\JsonResponse;

class CurrencyConversionController extends Controller
{
    /**
     * @var CurrencyConversionService
     */
    private CurrencyConversionService $service;

    /**
     * @param CurrencyConversionService $service
     */
    public function __construct(CurrencyConversionService $service)
    {
        $this->service = $service;
    }

    /**
     * @param CurrencyConversionRequest $conversionRequest
     * @return JsonResponse
     * @throws Exception
     */
    public function store(CurrencyConversionRequest $conversionRequest): JsonResponse
    {
        return response()->json($this->service->convertToCryptoCurrency($conversionRequest->toDTO()));
    }
}
