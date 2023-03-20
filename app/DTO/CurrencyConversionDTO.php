<?php

namespace App\DTO;

class CurrencyConversionDTO
{
    /** @var float */
    private float $amountMoney;

    /** @var string */
    private string $currencyMoney;

    /** @var string */
    private string $currencyCrypto;

    /** @var float */
    private float $amountCrypto;

    /**
     * @param float $amountMoney
     * @param string $currencyMoney
     * @param string $currencyCrypto
     */
    public function __construct(float $amountMoney, string $currencyMoney, string $currencyCrypto)
    {
        $this->amountMoney    = $amountMoney;
        $this->currencyMoney  = $currencyMoney;
        $this->currencyCrypto = $currencyCrypto;
    }

    /**
     * @return float
     */
    public function getAmountMoney(): float
    {
        return $this->amountMoney;
    }

    /**
     * @return string
     */
    public function getCurrencyMoney(): string
    {
        return $this->currencyMoney;
    }

    /**
     * @return string
     */
    public function getCurrencyCrypto(): string
    {
        return $this->currencyCrypto;
    }

    /**
     * @return string
     */
    public function getAmountCrypto(): string
    {
        return $this->amountCrypto;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function setAmountCrypto(float $amount): void
    {
        $this->amountCrypto = $amount;
    }
}
