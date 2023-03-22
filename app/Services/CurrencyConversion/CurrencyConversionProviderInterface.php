<?php

namespace App\Services\CurrencyConversion;

use App\DTO\CurrencyConversionDTO;

interface CurrencyConversionProviderInterface
{
    public function getConversion(CurrencyConversionDTO $dto);
}
