<?php

namespace Tests\Unit;

use App\DTO\CurrencyConversionDTO;
use App\Models\CurrencyConversion;
use App\Services\CurrencyConversion\CoinApi\CoinApiService;
use App\Services\CurrencyConversion\CurrencyConversionService;
use App\Services\CurrencyConversion\ExchangeRate\ExchangeRateService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyConversionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @var ExchangeRateService */
    private ExchangeRateService $exchangeRateService;
    /** @var CoinApiService */
    private CoinApiService $coinApiService;
    /** @var CurrencyConversionService */
    private CurrencyConversionService $conversionService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->exchangeRateService = new ExchangeRateService();
        $this->coinApiService = new CoinApiService();
        $this->conversionService = new CurrencyConversionService($this->exchangeRateService, $this->coinApiService);
    }

    /**
     * Tests if Exchange Rate service returns correct responses
     *
     * @return void
     * @throws Exception
     */
    public function test_exchange_rate_service_outcomes(): void
    {
        // Test a valid conversion
        $dto = new CurrencyConversionDTO('USD', 1.0, 'EUR');
        $conversion = $this->exchangeRateService->getConversion($dto);
        $this->assertInstanceOf(CurrencyConversion::class, $conversion);
        $this->assertEquals($dto->getToAmount(), $conversion->to_amount);
        $this->assertDatabaseHas('currency_conversions', [
            'from_currency' => $dto->getFromCurrency(),
            'from_amount' => $dto->getFromAmount(),
            'to_currency' => $dto->getToCurrency(),
            'api_provider' => config('crypto.providers.exchange_rate.name'),
        ]);

        // Test an invalid conversion
        $dto = new CurrencyConversionDTO('USD', 1.0, 'INVALID');
        $this->expectException(Exception::class);
        $this->exchangeRateService->getConversion($dto);
    }

    /**
     * Tests if Coin API service returns correct responses
     *
     * @return void
     * @throws Exception
     */
    public function test_coin_api_service_outcomes(): void
    {
        // Test a valid DTO
        $dto = new CurrencyConversionDTO('BTC', 1.0, 'USD');
        $conversion = $this->coinApiService->getConversion($dto);
        $this->assertInstanceOf(CurrencyConversion::class, $conversion);
        $this->assertEquals($dto->getToAmount(), $conversion->to_amount);
        $this->assertDatabaseHas('currency_conversions', [
            'from_currency' => $dto->getFromCurrency(),
            'from_amount' => $dto->getFromAmount(),
            'to_currency' => $dto->getToCurrency(),
            'api_provider' => config('crypto.providers.coin_api.name'),
        ]);

        // Test an invalid DTO
        $dto = new CurrencyConversionDTO('BTC', 1.0, 'INVALID');
        $this->expectException(Exception::class);
        $this->coinApiService->getConversion($dto);
    }

    /**
     * Tests if currency is converted successfully
     *
     * @return void
     */
    public function test_convert_currency_returns_correct_result(): void
    {
        $dto = new CurrencyConversionDTO('EUR', 1.0, 'BTC');
        $result = $this->conversionService->convertCurrency($dto);
        $this->assertInstanceOf(CurrencyConversion::class, $result);

        $dto = new CurrencyConversionDTO('PLN', 1.0, 'BTC');
        $result = $this->conversionService->convertCurrency($dto);
        $this->assertInstanceOf(CurrencyConversion::class, $result);
    }

    /**
     * Tests if correct fallback providers are returned
     *
     * @return void
     */
    public function test_fallback_providers_return(): void
    {
        $dto = new CurrencyConversionDTO('PLN', 1.0, 'btc');
        $this->expectException(Exception::class);
        $this->conversionService->convertCurrency($dto);

        $dto = new CurrencyConversionDTO('EUR', 1.0, 'INVALID');
        $this->expectException(Exception::class);
        $this->conversionService->convertCurrency($dto);
    }
}
