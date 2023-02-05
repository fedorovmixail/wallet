<?php

namespace Wallet\Services\BalanceUpdater\CurrencyCast;

use Wallet\Models\CurrencyRate;

interface CastInterface
{
    public function cast(float $amount, CurrencyRate $currencyRate): float;
}