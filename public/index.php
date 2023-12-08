<?php

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . "/../config/bootstrap.php";

require_once __DIR__ . "/../config/routes.php";

$twig = Twig::create(__DIR__ . "/../resources/views", ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->run();