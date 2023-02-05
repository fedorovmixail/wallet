<?php

use Aura\Di\ContainerBuilder;
use Wallet\DiConfig;
use Wallet\Utils\Db;

require __DIR__ . '/vendor/autoload.php';
$di = (new ContainerBuilder())->newConfiguredInstance([
    DiConfig::class,
]);
/** @var Db $db */
$db = $di->get(Db::class);
$pdo = $db->getConnect();

$pdo->exec('drop table wallet');
$pdo->exec('drop table currency_rate');
$pdo->exec('drop table currency');



$pdo->exec('
    create table if not exists currency
    (
        id int unsigned auto_increment primary key,
        currency varchar(5) not null
    ) engine=innoDb character set utf8 COLLATE utf8_general_ci;
');
$pdo->exec('
    insert into currency (id, currency) values (1, "rub"), (2, "usd")
');

$pdo->exec('
    create table if not exists currency_rate
    (
        currency varchar(5) not null,
        rate_currency varchar(5) not null,
        rate decimal(13, 5) not null,
        primary key(currency, rate_currency)
    ) engine=innoDb character set utf8 COLLATE utf8_general_ci;
');
$pdo->exec('
    insert into currency_rate (currency, rate_currency, rate) 
    values ("rub", "usd", 70), ("usd", "rub", 0.014)
');

$pdo->exec('
    create table if not exists wallet
    (
        wallet_id int unsigned auto_increment primary key,
        currency_id int unsigned not null,
        balance decimal(13, 5) not null default 0.00,
        unique index search_wallet (wallet_id, currency_id)
    ) engine=innoDb character set utf8 COLLATE utf8_general_ci;
');
$pdo->exec('
    insert into wallet (wallet_id, currency_id, balance)
    values (100, 1, 150.00),
        (101, 1, 0.00),
        (102, 1, -10.00),
        (103, 2, 150.00),
        (104, 2, 0.00),
        (105, 2, -10.00)
');

exit;