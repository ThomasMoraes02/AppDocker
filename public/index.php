<?php

use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . "/../config/bootstrap.php";

require_once __DIR__ . "/../config/routes.php";

$container->set('view', function(ContainerInterface $container) {
    return Twig::create(__DIR__ . "/../src/UI/Templates", ['cache' => false]);
});

$twig = $container->get('view');
$app->add(TwigMiddleware::create($app, $twig));

$app->run();