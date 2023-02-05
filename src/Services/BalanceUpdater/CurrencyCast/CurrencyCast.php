<?php

namespace Wallet\Services\BalanceUpdater\CurrencyCast;

use Wallet\Models\CurrencyRate;

class CurrencyCast implements CastInterface
{
    public function cast(float $amount, CurrencyRate $currencyRate): float
    {
        return $amount * $currencyRate->getRate();
    }
}