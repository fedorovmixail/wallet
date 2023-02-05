<?php

namespace Wallet\Utils;

use Aura\Sql\ExtendedPdo;

class Db
{
    private string $host;
    private string $dbName;
    private string $user;
    private string $pass;
    private static ?ExtendedPdo $instance = null;

    public function __construct(string $host, string $dbName, string $user, string $pass)
    {
        $this->setDbName($dbName);
        $this->setHost($host);
        $this->setPass($pass);
        $this->setUser($user);
    }

    public function getConnect(): ExtendedPdo
    {
        if (self::$instance === null) {
            $pdo = new ExtendedPdo(
                "mysql:host={$this->getHost()};dbname={$this->getDbName()}",
                $this->getUser(),
                $this->getPass(),
            );
            self::$instance = $pdo;
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }

    /**
     * @param string $dbName
     */
    public function setDbName(string $dbName): void
    {
        $this->dbName = $dbName;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }
}