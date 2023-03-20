<?php

namespace App\Services\Crypto;

use App\DTO\CurrencyConversionDTO;
use App\Models\CurrencyConversion;

abstract class CryptoServiceAbstract
{
    /**
     * @var CurrencyConversionDTO
     */
    protected CurrencyConversionDTO $conversionDto;

    /**
     * @param CurrencyConversionDTO $conversionDto
     */
    public function __construct(CurrencyConversionDTO $conversionDto)
    {
        $this->conversionDto = $conversionDto;
    }

    /**
     * @param string $provider
     * @return CurrencyConversion
     */
    public function createConversion(string $provider): CurrencyConversion
    {
        return CurrencyConversion::create([
            'provider'        => $provider,
            'currency_money'  => $this->conversionDto->getCurrencyMoney(),
            'amount'          => $this->conversionDto->getAmountMoney(),
            'currency_crypto' => $this->conversionDto->getCurrencyCrypto(),
            'amount_crypto'   => $this->conversionDto->getAmountCrypto()
        ]);
    }
}
