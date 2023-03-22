<?php

namespace App\Services\CurrencyConversion\ExchangeRate;

use App\DTO\CurrencyConversionDTO;
use App\Models\CurrencyConversion;
use App\Services\CurrencyConversion\CurrencyConversionProvider;
use App\Services\CurrencyConversion\CurrencyConversionProviderInterface;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ExchangeRateService extends CurrencyConversionProvider implements CurrencyConversionProviderInterface
{
    /** @var string */
    private string $endpoint;

    public function __construct()
    {
        $this->endpoint = config('crypto.providers.exchange_rate.url');
    }

    /**
     * @param CurrencyConversionDTO $dto
     * @return CurrencyConversion
     * @throws Exception
     */
    public function getConversion(CurrencyConversionDTO $dto): CurrencyConversion
    {
        $response = $this->sendRequest($dto);
        if ($response->failed() || is_null($response->json()['result'])) {
            throw new Exception('Exchange Rate provider failed');
        }

        $dto->setToAmount($response->json()['result']);

        return $this->createCurrencyConversion($dto);
    }

    /**
     * @param CurrencyConversionDTO $currencyConversionDTO
     * @return Response
     */
    private function sendRequest(CurrencyConversionDTO $currencyConversionDTO): Response
    {
        return Http::get($this->endpoint, [
            'from' => $currencyConversionDTO->getFromCurrency(),
            'to' => $currencyConversionDTO->getToCurrency(),
            'amount' => $currencyConversionDTO->getFromAmount(),
        ]);
    }

    /**
     * @return string
     */
    protected function getProviderName(): string
    {
        return config('crypto.providers.exchange_rate.name');
    }
}
