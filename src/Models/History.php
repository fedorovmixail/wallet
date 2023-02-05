<?php

namespace Wallet\Models;

class History
{
    private int $id;
    private int $wallet_id;
    private string $type;
    private float $amount;
    private string $currency;
    private string $reason;

    public const REASON_STOCK = 'stock';
    public const REASON_REFUND = 'refund';
    public const REASONS_LIST = [self::REASON_STOCK, self::REASON_REFUND];

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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

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
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }
}