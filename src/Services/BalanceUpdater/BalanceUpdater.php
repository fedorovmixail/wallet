<?php

namespace Wallet\Services\BalanceUpdater;

use Wallet\Repositories\CurrencyRepo;
use Wallet\Repositories\HistoryRepo;
use Wallet\Repositories\WalletRepo;
use Wallet\Services\BalanceUpdater\CurrencyCast\CurrencyCastFactory;
use Wallet\Services\BalanceUpdater\UpdateStrategies\UpdateStrategyFactory;

class BalanceUpdater
{
    private WalletRepo $walletRepo;
    private UpdateStrategyFactory $updateStrategyFactory;
    private CurrencyRepo $currencyRepo;
    private CurrencyCastFactory $currencyCastFactory;
    private HistoryRepo $HistoryRepo;

    public function __construct(
        WalletRepo $walletRepo,
        UpdateStrategyFactory $updateStrategyFactory,
        CurrencyRepo $currencyRepo,
        CurrencyCastFactory $currencyCastFactory,
        HistoryRepo $historyRepo
    ) {
        $this->walletRepo = $walletRepo;
        $this->updateStrategyFactory = $updateStrategyFactory;
        $this->currencyRepo = $currencyRepo;
        $this->currencyCastFactory = $currencyCastFactory;
        $this->historyRepo = $historyRepo;
    }

    public function updateBalance(
        int $walletId,
        string $updateType,
        float $amount,
        string $paidCurrency,
        string $reason
    ): array {
        $this->walletRepo->beginTransaction();
        try {
            if (!$wallet = $this->walletRepo->getWallet($walletId)) {
                throw new \Exception("Wallet $walletId not found");
            }

            if (!$walletCurrency = $this->currencyRepo->getCurrency($wallet->getCurrencyId())) {
                throw new \Exception('Wrong currency');
            }
            if ($walletCurrency->getCurrency() != $paidCurrency) {
                $walletCurrencyRate = $this->currencyRepo->getCurrencyRate($walletCurrency->getCurrency(), $paidCurrency);
                if (!$walletCurrencyRate) {
                    throw new \Exception('Wrong rate');
                }
                $amountInWalletCurrency = $this->currencyCastFactory->getInstance()->cast($amount, $walletCurrencyRate);
            } else {
                $amountInWalletCurrency = $amount;
            }

            $updateStrategy = $this->updateStrategyFactory->getInstance($updateType);
            if (!$updateStrategy->canUpdate($wallet, $amountInWalletCurrency)) {
                throw new \Exception("Operation doesn't permitted");
            }

            if (!$this->walletRepo->updateWalletBalance($wallet->getWalletId(), $amountInWalletCurrency)) {
                throw new \Exception("Update balance failure");
            }

            if (!$this->historyRepo->saveInHistory(
                $wallet->getWalletId(),
                $updateType,
                $amountInWalletCurrency,
                $paidCurrency,
                $reason
            )) {
                throw new \Exception("Save history failure");
            };
            $newBalance = $this->walletRepo->getWalletAr($walletId);

            $this->walletRepo->commit();

            return $newBalance;
        } catch (\Throwable $e) {
            $this->walletRepo->rollback();
            throw $e;
        }
    }
}