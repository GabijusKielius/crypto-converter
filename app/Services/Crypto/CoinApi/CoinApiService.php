<?php

namespace App\Services\Crypto\CoinApi;

use App\Models\CurrencyConversion;
use App\Services\Crypto\CryptoServiceAbstract;
use App\Services\Crypto\CryptoService;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CoinApiService extends CryptoServiceAbstract implements CryptoService
{
    /**
     * @return CurrencyConversion
     * @throws Exception
     */
    public function getCrypto(): CurrencyConversion
    {
        $response = $this->call();

        if (isset($response->json()['error'])) {
            throw new Exception($response->json()['error']);
        }

        $cryptoAmount = $this->prepareCryptoAmount($response->json()['rate']);
        $this->conversionDto->setAmountCrypto($cryptoAmount);

        return $this->createConversion(config('crypto.providers.coin_api.name'));
    }

    /**
     * @return Response
     */
    public function call(): Response
    {
        return Http::withHeaders(
            ['X-CoinAPI-Key' => config('crypto.providers.coin_api.key')
            ])->get($this->prepareApiUrl());
    }

    /**
     * @return string
     */
    private function prepareApiUrl(): string
    {
        return config('crypto.providers.coin_api.url') .
        $this->conversionDto->getCurrencyMoney() . '/' .
        $this->conversionDto->getCurrencyCrypto();
    }

    /**
     * @param float $rate
     * @return float
     */
    private function prepareCryptoAmount(float $rate): float
    {
        return round($this->conversionDto->getAmountMoney() * $rate, 6);
    }
}
