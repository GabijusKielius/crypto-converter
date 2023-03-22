<?php

namespace App\DTO;

class CurrencyConversionDTO
{
    /** @var string */
    private string $fromCurrency;

    /** @var float */
    private float $fromAmount;

    /** @var string */
    private string $toCurrency;

    /** @var float|null */
    private ?float $toAmount;

    /**
     * @param string $fromCurrency
     * @param float $fromAmount
     * @param string $toCurrency
     */
    public function __construct(string $fromCurrency, float $fromAmount, string $toCurrency)
    {
        $this->fromCurrency = $fromCurrency;
        $this->fromAmount = $fromAmount;
        $this->toCurrency = $toCurrency;
        $this->toAmount = null;
    }

    /**
     * @return string
     */
    public function getFromCurrency(): string
    {
        return $this->fromCurrency;
    }

    /**
     * @return float
     */
    public function getFromAmount(): float
    {
        return $this->fromAmount;
    }

    /**
     * @return string
     */
    public function getToCurrency(): string
    {
        return $this->toCurrency;
    }

    /**
     * @return float|null
     */
    public function getToAmount(): ?float
    {
        return $this->toAmount;
    }

    /**
     * @param float $toAmount
     * @return void
     */
    public function setToAmount(float $toAmount): void
    {
        $this->toAmount = $toAmount;
    }
}
