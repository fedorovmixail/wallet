<?php

namespace Wallet\Services\BalanceUpdater\UpdateStrategies;

class UpdateStrategyFactory
{
    public const UPDATE_STRATEGY_DEBIT = 'debit';
    public const UPDATE_STRATEGY_CREDIT = 'credit';
    public const UPDATE_STRATEGIES = [
        self::UPDATE_STRATEGY_CREDIT,
        self::UPDATE_STRATEGY_DEBIT
    ];

    public function getInstance(string $type): UpdateStrategyInterface
    {
        switch ($type) {
            case self::UPDATE_STRATEGY_DEBIT:
                return new DebitStrategy();
            case self::UPDATE_STRATEGY_CREDIT:
                return new CreditStrategy();
            default:
                throw new \Exception("Update strategy type $type, not found");
        }
    }
}