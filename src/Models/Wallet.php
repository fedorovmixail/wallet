<?php

namespace Wallet\Models;

class Wallet
{
    private int $wallet_id;
    private int $currency_id;
    private float $balance;

    /**
     * @return int
     */
    public function getWalletId(): int
    {
        return $this->wallet_id;
    }

    /**
     * @param int $wallet_id
     */
    public function setWalletId(int $wallet_id): void
    {
        $this->wallet_id = $wallet_id;
    }

    /**
     * @return int
     */
    public function getCurrencyId(): int
    {
        return $this->currency_id;
    }

    /**
     * @param int $currency_id
     */
    public function setCurrencyId(int $currency_id): void
    {
        $this->currency_id = $currency_id;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }
}