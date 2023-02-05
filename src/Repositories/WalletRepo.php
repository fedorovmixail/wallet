<?php

namespace Wallet\Repositories;

use Wallet\Models\Wallet;

class WalletRepo extends Repository
{
    public function getWallet(int $walletId): ?Wallet
    {
        $pdo = $this->getDb()->getConnect();
        $sql = 'SELECT * FROM wallet WHERE wallet_id = :walletId FOR UPDATE';

        $result = $pdo->fetchObject(
            $sql,
            ['walletId' => $walletId],
            Wallet::class
        );

        if (!$result instanceof Wallet) {
            return null;
        } else {
            return $result;
        }
    }

    public function updateWalletBalance(int $walletId, int $updBalance): bool
    {
        $pdo = $this->getDb()->getConnect();
        $sql = 'UPDATE wallet SET balance = balance + :updBalance WHERE wallet_id = :walletId';

        $sth = $pdo->prepare($sql);

        return $sth->execute(['walletId' => $walletId, 'updBalance' => $updBalance]);
    }
}