<?php

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require_once __DIR__ . "/../vendor/autoload.php";

$dotEnv = Dotenv::createImmutable(__DIR__ . "/../");
$dotEnv->load();

$container = require __DIR__ . "/container.php";

AppFactory::setContainer($container);

$app = AppFactory::create();

// Slim Errors Default
// $app->addErrorMiddleware(true, true, true);

// Cache Route
// $routeCollector = $app->getRouteCollector();
// $routeCollector->setCacheFile(__DIR__ . "/../storage/cache/cache.file");