<?php

namespace Wallet\Repositories;

use Wallet\Models\Currency;
use Wallet\Models\CurrencyRate;

class CurrencyRepo extends Repository
{
    public function getCurrency(int $id): ?Currency
    {
        $pdo = $this->getDb()->getConnect();
        $sql = 'SELECT * FROM currency WHERE id = :id';

        $result = $pdo->fetchObject($sql, ['id' => $id], Currency::class);

        if (!$result instanceof Currency) {
            return null;
        } else {
            return $result;
        }
    }

    public function getCurrencyRate(string $walletCurrency, string $paidCurrency): ?CurrencyRate
    {
        $pdo = $this->getDb()->getConnect();
        $sql = 'SELECT * FROM currency_rate WHERE currency = :currency and  rate_currency = :paidCurrency';

        $result = $pdo->fetchObject(
            $sql,
            ['currency' => $walletCurrency, 'paidCurrency' => $paidCurrency],
            CurrencyRate::class
        );

        if (!$result instanceof CurrencyRate) {
            return null;
        } else {
            return $result;
        }
    }
}