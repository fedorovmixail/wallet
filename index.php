<?php

//phpinfo();

use Aura\Di\ContainerBuilder;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Wallet\DiConfig;
use Wallet\Services\AuthService;
use Wallet\Services\BalanceUpdater\BalanceUpdater;
use Wallet\Services\ValidatorService;
use Wallet\Utils\Db;
use Wallet\Validators\FillValidator;
//use Zend\Diactoros\Response;
//use Zend\Diactoros\ServerRequest;
//use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/vendor/autoload.php';

const REASON_STOCK = 'stock';
const REASON_REFUND = 'refund';
const REASONS_LIST = [REASON_STOCK, REASON_REFUND];

$di = (new ContainerBuilder())->newConfiguredInstance([
    DiConfig::class,
]);



//
///** @var Db $db */
//$db = $di->get(Db::class);
//$pdo = $db->getDb();
//
//$r = $pdo->fetchAll('select * from wallet');
//$r2 = $pdo->fetchAll('select * from currency');
//
////var_dump($pdo);
//var_dump($r);
//var_dump($r2);
//exit;




/** @var AuthService $authService */
$authService = $di->get(AuthService::class);
/** @var ValidatorService $validateService */
$validateService = $di->get(ValidatorService::class);
/** @var BalanceUpdater $balanceUpdater */
$balanceUpdater = $di->get(BalanceUpdater::class);

$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);



$routerContainer = new Aura\Router\RouterContainer();
$map = $routerContainer->getMap();

$map->post('fill', '/fill', function (ServerRequest $request) use ($validateService, $di, $balanceUpdater) {

    $response = $di->get(Response::class);
    $params = $request->getParsedBody();
    if (!$validateService->validate(FillValidator::class, $params)) {
        $response->getBody()->write(json_encode($validateService->getMessages()));

        return $response;
    }

    var_dump($balanceUpdater->updateBalance(
        $params['wallet_id'],
        $params['type'],
        $params['amount'],
        $params['currency'],
        $params['reason'],
    ));

    $response->getBody()->write("OK");

    return $response;
})->auth($authService->auth($request));;

$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);
if (! $route) {
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