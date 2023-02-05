<?php

use Aura\Di\ContainerBuilder;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Wallet\DiConfig;
use Wallet\Repositories\HistoryRepo;
use Wallet\Repositories\WalletRepo;
use Wallet\Services\AuthService;
use Wallet\Services\BalanceUpdater\BalanceUpdater;
use Wallet\Services\ValidatorService;
use Wallet\Utils\Db;
use Wallet\Validators\BalanceValidator;
use Wallet\Validators\FillValidator;
use Wallet\Validators\LastValidator;

require __DIR__ . '/vendor/autoload.php';

$di = (new ContainerBuilder())->newConfiguredInstance([
    DiConfig::class,
]);
/** @var AuthService $authService */
$authService = $di->get(AuthService::class);
/** @var ValidatorService $validateService */
$validateService = $di->get(ValidatorService::class);
/** @var BalanceUpdater $balanceUpdater */
$balanceUpdater = $di->get(BalanceUpdater::class);

$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$routerContainer = new Aura\Router\RouterContainer();
$map = $routerContainer->getMap();

$map->post('fill', '/fill', function (ServerRequest $request) use ($validateService, $di, $balanceUpdater) {
    $response = $di->get(Response::class);
    $params = $request->getParsedBody();
    if (!$validateService->validate(FillValidator::class, $params)) {
        $response->getBody()->write(json_encode($validateService->getMessages()));

        return $response;
    }

    $result = $balanceUpdater->updateBalance(
        $params['wallet_id'],
        $params['type'],
        $params['amount'],
        $params['currency'],
        $params['reason'],
    );

    $response->getBody()->write(json_encode($result));

    return $response;
})->auth($authService->auth($request));

$map->get('last', '/last/{lastDays}/{reason}', function (ServerRequest $request) use ($validateService, $di) {
    $response = $di->get(Response::class);
    /** @var HistoryRepo $historyRepo */
    $historyRepo = $di->get(HistoryRepo::class);
    $params = $request->getAttributes();

    if (!$validateService->validate(LastValidator::class, $params)) {
        $response->getBody()->write(json_encode($validateService->getMessages()));

        return $response;
    }
    $result = $historyRepo->getHistoryByReason($params['reason'], time() - ($params['lastDays'] * 86400));
    $response->getBody()->write(json_encode($result));

    return $response;
})->auth($authService->auth($request));

$map->get('balance', '/balance/{wallet}', function (ServerRequest $request) use ($validateService, $di) {
    $response = $di->get(Response::class);
    /** @var WalletRepo $walletRepo */
    $walletRepo = $di->get(WalletRepo::class);
    $params = $request->getAttributes();

    if (!$validateService->validate(BalanceValidator::class, $params)) {
        $response->getBody()->write(json_encode($validateService->getMessages()));

        return $response;
    }

    if (!$result = $walletRepo->getWalletAr($params['wallet'])) {
        $response->getBody()->write(json_encode(['reason' => 'not found']));
    }

    $response->getBody()->write(json_encode($result));

    return $response;
})->auth($authService->auth($request));

$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);
if (!$route) {
    echo "No route found for the request.";
    exit;
} else if ($route->auth['role'] !== 'admin') {
    echo 'Access denied';
    exit;
}

foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

$callable = $route->handler;
$response = $callable($request);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
http_response_code($response->getStatusCode());
echo $response->getBody();