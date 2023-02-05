<?php

namespace Wallet\Repositories;

use Wallet\Utils\Db;

class Repository
{
    private Db $db;

    public function __construct(Db $db)
    {
        $this->setDb($db);
    }


    public function beginTransaction()
    {
        $pdo = $this->getDb()->getConnect();
        $pdo->beginTransaction();
    }

    public function commit()
    {
        $pdo = $this->getDb()->getConnect();
        $pdo->commit();
    }

    public function rollback()
    {
        $pdo = $this->getDb()->getConnect();
        $pdo->rollBack();
    }

    /**
     * @return Db
     */
    public function getDb(): Db
    {
        return $this->db;
    }

    /**
     * @param Db $db
     */
    public function setDb(Db $db): void
    {
        $this->db = $db;
    }
}