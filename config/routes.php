<?php 

use Slim\Factory\AppFactory;
use App\Presentation\Controllers\UserController;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);;

$routeCollector = $app->getRouteCollector();
$routeCollector->setCacheFile(__DIR__ . "/../storage/cache/cache.file");

$app->post("/users", [UserController::class, 'store']);
$app->get("/users/{uuid}",[UserController::class, 'show']);
$app->delete("/users/{uuid}",[UserController::class, 'destroy']);
$app->put("/users/{uuid}",[UserController::class, 'update']);