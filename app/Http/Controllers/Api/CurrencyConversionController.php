<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyConversionRequest;
use Illuminate\Http\JsonResponse;

class CurrencyConversionController extends Controller
{
    /**
     * @param CurrencyConversionRequest $conversionRequest
     * @return JsonResponse
     */
    public function store(CurrencyConversionRequest $conversionRequest): JsonResponse
    {
        return response()->json(true);
    }
}
