<?php

namespace Wallet\Services\BalanceUpdater\UpdateStrategies;

use Wallet\Models\Wallet;

interface UpdateStrategyInterface
{
    public function canUpdate(Wallet $wallet, float $amount): bool;
}