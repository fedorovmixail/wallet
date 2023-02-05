<?php

namespace Wallet\Services\BalanceUpdater\UpdateStrategies;

use Wallet\Models\Wallet;

class CreditStrategy implements UpdateStrategyInterface
{

    public function canUpdate(Wallet $wallet, float $amount): bool
    {
        return $wallet->getBalance() > $amount;
    }
}