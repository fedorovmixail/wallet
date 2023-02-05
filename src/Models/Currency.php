<?php

namespace Wallet\Models;

class Currency
{
    public const CURRENCY_RUB = 'rub';
    public const CURRENCY_USD = 'usd';
    public const CURRENCY_LIST = [self::CURRENCY_RUB, self::CURRENCY_USD];

    private int $id;
    private string $currency;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(string $id): void
    {
        $this->id = (int)$id;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        if (!in_array($this->currency, self::CURRENCY_LIST)) {
            throw new \Exception("Currency $this->currency doesn't supported");
        }
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        if (!in_array($currency, self::CURRENCY_LIST)) {
            throw new \Exception("Currency $currency doesn't supported");
        }
        $this->currency = $currency;
    }
}
