<?php

namespace App\Services\CurrencyConversion;

use App\DTO\CurrencyConversionDTO;
use App\Models\CurrencyConversion;
use App\Services\CurrencyConversion\CoinApi\CoinApiService;
use App\Services\CurrencyConversion\ExchangeRate\ExchangeRateService;
use Exception;

class CurrencyConversionService
{
    private ExchangeRateService $exchangeRateService;
    private CoinApiService $coinApiService;

    public function __construct(ExchangeRateService $exchangeRateService, CoinApiService $coinApiService)
    {
        $this->exchangeRateService = $exchangeRateService;
        $this->coinApiService = $coinApiService;
    }

    /**
     * @param CurrencyConversionDTO $dto
     * @return CurrencyConversion
     */
    public function convertCurrency(CurrencyConversionDTO $dto): CurrencyConversion
    {
        $provider = $this->getProvider($dto->getFromCurrency());
        try {
            return $provider->getConversion($dto);
        } catch (Exception $exception) {
            return $this->getFallBackProvider($provider)->getConversion($dto);
        }
    }

    /**
     * @param string $currencyCode
     * @return CurrencyConversionProviderInterface
     */
    public function getProvider(string $currencyCode): CurrencyConversionProviderInterface
    {
        return match ($currencyCode) {
            CurrencyConversion::CURRENCY_PLN => $this->coinApiService,
            default => $this->exchangeRateService,
        };
    }

    /**
     * @param CurrencyConversionProviderInterface $provider
     * @return CurrencyConversionProviderInterface
     */
    private function getFallBackProvider(CurrencyConversionProviderInterface $provider): CurrencyConversionProviderInterface
    {
        if ($provider instanceof ExchangeRateService) {
            return $this->coinApiService;
        }
        return $this->exchangeRateService;
    }
}
