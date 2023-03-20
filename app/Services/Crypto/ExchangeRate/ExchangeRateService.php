<?php

namespace App\Services\Crypto\ExchangeRate;

use App\Models\CurrencyConversion;
use App\Services\Crypto\CryptoServiceAbstract;
use App\Services\Crypto\CryptoService;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ExchangeRateService extends CryptoServiceAbstract implements CryptoService
{
    /**
     * @return CurrencyConversion
     * @throws Exception
     */
    public function getCrypto(): CurrencyConversion
    {
        $response = $this->call();

        if ($response->failed() || is_null($response->json()['result'])) {
            throw new Exception('Exchange Rate provider failed');
        }

        $this->conversionDto->setAmountCrypto($response->json()['result']);

        return $this->createConversion(config('crypto.providers.exchange_rate.name'));
    }

    /**
     * @return Response
     */
    public function call(): Response
    {
        return Http::get(config('crypto.providers.exchange_rate.url'), [
            'from'   => $this->conversionDto->getCurrencyMoney(),
            'to'     => $this->conversionDto->getCurrencyCrypto(),
            'amount' => $this->conversionDto->getAmountMoney(),
        ]);
    }

}
