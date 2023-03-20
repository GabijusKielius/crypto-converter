<?php

namespace App\Services;

use App\DTO\CurrencyConversionDTO;
use App\Models\CurrencyConversion;
use App\Services\Crypto\CoinApi\CoinApiService;
use App\Services\Crypto\CryptoService;
use App\Services\Crypto\ExchangeRate\ExchangeRateService;
use Exception;
use Illuminate\Support\Facades\Log;

class CurrencyConversionService
{
    /**
     * @param CurrencyConversionDTO $conversionDto
     * @return CurrencyConversion
     * @throws Exception
     */
    public function convertToCryptoCurrency(CurrencyConversionDTO $conversionDto): CurrencyConversion
    {
        $provider = $this->getCryptoProvider($conversionDto);
        try {
            return $provider->getCrypto();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return $this->getFallBackProvider($conversionDto, $provider)->getCrypto();
        }
    }

    /**
     * @param CurrencyConversionDTO $conversionDto
     * @return CryptoService
     */
    private function getCryptoProvider(CurrencyConversionDTO $conversionDto): CryptoService
    {
        return match ($conversionDto->getCurrencyMoney()) {
            CurrencyConversion::CURRENCY_PLN => new CoinApiService($conversionDto),
            default                          => new ExchangeRateService($conversionDto),
        };
    }

    /**
     * @param CurrencyConversionDTO $conversionDto
     * @param CryptoService $provider
     * @return CryptoService
     */
    private function getFallBackProvider(CurrencyConversionDTO $conversionDto, CryptoService $provider): CryptoService
    {
        if ($provider instanceof ExchangeRateService) {
            return new CoinApiService($conversionDto);
        }
        return new ExchangeRateService($conversionDto);
    }
}
