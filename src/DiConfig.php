<?php

namespace Wallet;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use Aura\Filter\FilterFactory;
use Laminas\Diactoros\Response;
use Wallet\Repositories\CurrencyRepo;
use Wallet\Repositories\WalletRepo;
use Wallet\Services\AuthService;
use Wallet\Services\BalanceUpdater\BalanceUpdater;
use Wallet\Services\BalanceUpdater\CurrencyCast\CurrencyCastFactory;
use Wallet\Services\BalanceUpdater\UpdateStrategies\UpdateStrategyFactory;
use Wallet\Services\ValidatorService;
use Wallet\Utils\Db;


class DiConfig extends ContainerConfig
{
    public function define(Container $di): void
    {
        $di->set(AuthService::class, $di->lazyNew(AuthService::class));

        $di->set(Response::class, $di->lazyNew(Response::class));

        $di->params[Db::class] = array(
            'host' => 'db',
            'dbName' => 'wallet',
            'user' => 'test',
            'pass' => 'test',
        );
        $di->set(Db::class, $di->lazyNew(Db::class));

        $di->params[BalanceUpdater::class] = array(
            'db' => $di->lazyNew(Db::class)
        );
        $di->set(WalletRepo::class, $di->lazyNew(WalletRepo::class));

        $di->params[BalanceUpdater::class] = array(
            'db' => $di->lazyNew(Db::class)
        );
        $di->set(CurrencyRepo::class, $di->lazyNew(CurrencyRepo::class));

        $di->params[BalanceUpdater::class] = array(
            'walletRepo' => $di->lazyNew(WalletRepo::class, [$di->lazyNew(Db::class)]),
            'updateStrategyFactory' => $di->lazyNew(UpdateStrategyFactory::class),
            'currencyRepo' => $di->lazyNew(CurrencyRepo::class, [$di->lazyNew(Db::class)]),
            'currencyCastFactory' => $di->lazyNew(CurrencyCastFactory::class),
        );
        $di->set(BalanceUpdater::class, $di->lazyNew(BalanceUpdater::class));

        $di->params[ValidatorService::class] = array(
            'factory' => $di->lazyNew(FilterFactory::class),
        );
        $di->set(ValidatorService::class, $di->lazyNew(ValidatorService::class));
    }
}