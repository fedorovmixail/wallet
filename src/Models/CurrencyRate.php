<?php

namespace Wallet\Models;

class CurrencyRate
{
    private string $currency;
    private string $rate_currency;
    private float $rate;

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getRateCurrency(): string
    {
        return $this->rate_currency;
    }

    /**
     * @param string $rate_currency
     */
    public function setRateCurrency(string $rate_currency): void
    {
        $this->rate_currency = $rate_currency;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }
}