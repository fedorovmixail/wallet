<?php

namespace Wallet\Services\BalanceUpdater\CurrencyCast;

/**
 * If are variations will add another instance.
 */
class CurrencyCastFactory
{
    public function getInstance(): CurrencyCast
    {
        return new CurrencyCast();
    }
}