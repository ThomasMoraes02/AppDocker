<?php 

use Slim\Psr7\Request;
use Slim\Exception\HttpNotFoundException;
use App\Presentation\Controllers\UserController;
use App\Presentation\Middlewares\CorsMiddleware;
use App\Presentation\Middlewares\ErrorMiddleware;
use App\Presentation\Middlewares\OutputDefaultMiddleware;

/** @var Slim\App $app */

$app->add(ErrorMiddleware::class);
// $app->add(OutputDefaultMiddleware::class);
$app->add(CorsMiddleware::class);

$app->get("/users", [UserController::class, 'index']);
$app->post("/users", [UserController::class, 'store']);
$app->get("/users/{uuid}",[UserController::class, 'show']);
$app->delete("/users/{uuid}",[UserController::class, 'destroy']);
$app->put("/users/{uuid}",[UserController::class, 'update']);

// Fallback route
$app->get("/{any:.*}",fn(Request $request) => throw new HttpNotFoundException($request, 'Resource Not Found'));