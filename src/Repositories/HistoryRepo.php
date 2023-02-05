<?php

namespace Wallet\Repositories;

class HistoryRepo extends Repository
{
    public function saveInHistory(
        int $walletId,
        string $type,
        float $amount,
        string $currency,
        string $reason
    ): bool {
        $pdo = $this->getDb()->getConnect();
        $sql = '
            INSERT INTO history (wallet_id, type, amount, currency, reason, datets)
            VALUES (:walletId, :type, :amount, :currency, :reason, now())
        ';

        $sth = $pdo->prepare($sql);

        return $sth->execute([
            'walletId' => $walletId,
            'type' => $type,
            'amount' => $amount,
            'currency' => $currency,
            'reason' => $reason
        ]);
    }

    public function getHistoryByReason(string $reason, int $dateFrom): array
    {
        $pdo = $this->getDb()->getConnect();
        $sql = 'SELECT SUM(amount) as sum FROM history WHERE datets > :date AND reason = :reason GROUP BY reason';

        return $pdo->fetchOne($sql, ['date' => $dateFrom, 'reason' => $reason]);
    }
}