<?php 

use Slim\Factory\AppFactory;
use App\Presentation\Controllers\UserController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// $routeCollector = $app->getRouteCollector();
// $routeCollector->setCacheFile(__DIR__ . "/../storage/cache/cache.file");

$app->get("/users", [UserController::class, 'index']);
$app->post("/users", [UserController::class, 'store']);
$app->get("/users/{uuid}",[UserController::class, 'show']);
$app->delete("/users/{uuid}",[UserController::class, 'destroy']);
$app->put("/users/{uuid}",[UserController::class, 'update']);

$app->get("/", function (Request $request, Response $response, array $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'profile.html', [
        'name' => 'Slim Framework 4',
    ]);
});