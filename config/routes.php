<?php 

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use App\Presentation\Controllers\UserController;
use App\Presentation\Middlewares\CorsMiddleware;
use App\Presentation\Middlewares\ErrorMiddleware;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// $routeCollector = $app->getRouteCollector();
// $routeCollector->setCacheFile(__DIR__ . "/../storage/cache/cache.file");

$app->add(ErrorMiddleware::class);
// $app->add(OutputDefaultMiddleware::class);
$app->add(CorsMiddleware::class);

$app->get("/users", [UserController::class, 'index']);
$app->post("/users", [UserController::class, 'store']);
$app->get("/users/{uuid}",[UserController::class, 'show']);
$app->delete("/users/{uuid}",[UserController::class, 'destroy']);
$app->put("/users/{uuid}",[UserController::class, 'update']);


/**
 * Fallback route
 */
$app->get("/{any:.*}", function (Request $request, Response $response, array $args) {
    $response->getBody()->write(json_encode('Resource Not Found'));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});