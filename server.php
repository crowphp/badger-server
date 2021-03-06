#!/usr/bin/env php
<?php declare(strict_types=1);

if (!ini_get('date.timezone')) {
    ini_set('date.timezone', 'UTC');
}

if (!file_exists('./coverage')) {
    mkdir('./coverage');
}

foreach (array(__DIR__ . '/../../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
    if (file_exists($file)) {
        define('BADGER_COMPOSER_INSTALL', $file);

        break;
    }
}

unset($file);

if (!defined('BADGER_COMPOSER_INSTALL')) {
    fwrite(
        STDERR,
        'You need to set up the project dependencies using Composer:' . PHP_EOL . PHP_EOL .
        '    composer install' . PHP_EOL . PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . PHP_EOL
    );

    die(1);
}

require BADGER_COMPOSER_INSTALL;

use Crow\Http\Server\Factory as CrowServer;
use Crow\Router\Factory as CrowRouter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


$secretKey = $_SERVER["SECRET_KEY"] ?? null;
if (!$secretKey) {
    echo "SECRET_KEY environment variable is not defined" . PHP_EOL;
    exit(1);
}
if (!file_exists('./coverage')) {
    mkdir('./coverage');
}
$app = CrowServer::create(CrowServer::SWOOLE_SERVER);
$router = CrowRouter::make();
$router->post('/coverage/{branch_name}', function (
    ServerRequestInterface $request,
    ResponseInterface $response, $branchName) use ($secretKey) {
    if (
        !$request->hasHeader("secret-key") ||
        $request->getHeaderLine("secret-key") !== $secretKey
    ) {
        return $response->withStatus(403);
    }
    file_put_contents("coverage/" . $branchName . '.json', $request->getBody()->__toString());
    $response->getBody()->write($request->getBody()->__toString());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$router->get('/coverage/{branch_name}', function (
    ServerRequestInterface $request,
    ResponseInterface $response, $branchName) {

    $data = file_get_contents("coverage/" . $branchName . '.json');
    if ($data === FALSE) {
        throw new Exception("file not found");
    }
    $response->getBody()->write(
        $data
    );
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);


});

$app->withRouter($router);

$app->on('start', function ($server) {
    echo "Badger server listening on $server->host:$server->port" . PHP_EOL;
});
$app->listen(80, "0.0.0.0");