<?php

namespace App\Services\CurrencyConversion\CoinApi;

use App\DTO\CurrencyConversionDTO;
use App\Models\CurrencyConversion;
use App\Services\CurrencyConversion\CurrencyConversionProvider;
use App\Services\CurrencyConversion\CurrencyConversionProviderInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class CoinApiService extends CurrencyConversionProvider implements CurrencyConversionProviderInterface
{
    /** @var string */
    private string $endpoint;
    /** @var string */
    private string $apiKey;

    public function __construct()
    {
        $this->endpoint = config('crypto.providers.coin_api.url');
        $this->apiKey = config('crypto.providers.coin_api.key');
    }

    /**
     * @param CurrencyConversionDTO $dto
     * @return CurrencyConversion
     * @throws Exception
     */
    public function getConversion(CurrencyConversionDTO $dto): CurrencyConversion
    {
        $response = $this->sendRequest($dto);

        if ($response->failed() || is_null($response->json())) {
            throw new Exception('Coin API provider failed');
        }

        $dto->setToAmount(round($dto->getFromAmount() * $response->json()['rate'], 6));

        return $this->createCurrencyConversion($dto);
    }

    /**
     * @param CurrencyConversionDTO $currencyConversionDTO
     * @return Response
     */
    private function sendRequest(CurrencyConversionDTO $currencyConversionDTO): Response
    {
        return Http::withHeaders([
            'X-CoinAPI-Key' => $this->apiKey,
        ])->get("{$this->endpoint}/{$currencyConversionDTO->getFromCurrency()}/{$currencyConversionDTO->getToCurrency()}");
    }

    /**
     * @return string
     */
    protected function getProviderName(): string
    {
        return config('crypto.providers.coin_api.name');
    }
}
