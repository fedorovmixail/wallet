<?php

namespace Wallet\Services\BalanceUpdater\UpdateStrategies;

use Wallet\Models\Wallet;

class DebitStrategy implements UpdateStrategyInterface
{

    public function canUpdate(Wallet $wallet, float $amount): bool
    {
        return true;
    }
}