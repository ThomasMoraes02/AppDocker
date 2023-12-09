<?php 
namespace App\Presentation\Middlewares;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Throwable;

class ErrorMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly ContainerInterface $container) {}

    /**
     * Process an incoming server request and return a response, optionally delegating to the next middleware
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch(Throwable $e) {
            $this->container->get('Logging')->error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'stack' => $e->getTraceAsString(),
            ]);

            $response = new Response();
            $response->getBody()->write(json_encode([
                'errors' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'code' => $e->getCode(),
                ]
            ]));

            return $response->withStatus(400);
        }
    }
}