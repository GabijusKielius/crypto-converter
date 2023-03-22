<?php

namespace App\Services\CurrencyConversion;

use App\DTO\CurrencyConversionDTO;
use App\Models\CurrencyConversion;

abstract class CurrencyConversionProvider
{
    abstract public function getConversion(CurrencyConversionDTO $dto): CurrencyConversion;

    protected function createCurrencyConversion(CurrencyConversionDTO $dto): CurrencyConversion
    {
        $conversion = new CurrencyConversion();
        $conversion->from_currency = $dto->getFromCurrency();
        $conversion->from_amount = $dto->getFromAmount();
        $conversion->to_currency = $dto->getToCurrency();
        $conversion->to_amount = $dto->getToAmount();
        $conversion->api_provider = $this->getProviderName();
        $conversion->save();
        return $conversion;
    }

    abstract protected function getProviderName(): string;
}
