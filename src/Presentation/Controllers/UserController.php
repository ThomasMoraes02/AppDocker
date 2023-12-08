<?php 
namespace App\Presentation\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;
use App\Domain\Factories\UserFactory;
use App\Application\Repositories\UserRepository;
use App\Application\UseCases\User\LoadUser\LoadUser;
use App\Application\UseCases\User\CreateUser\CreateUser;
use App\Application\UseCases\User\DeleteUser\DeleteUser;
use App\Application\UseCases\User\UpdateUser\UpdateUser;
use Slim\Views\Twig;

class UserController
{
    private readonly UserRepository $userRepository;

    private readonly UserFactory $userFactory;

    private readonly Twig $view;

    public function __construct(ContainerInterface $container)
    {
        $this->userRepository = $container->get("UserRepository");
        $this->userFactory = $container->get("UserFactory");
        $this->view = $container->get('view');
    }

    public function index(Request $request, Response $response, array $args): Response
    {   
        return $this->view->render($response, 'index.html',[]);
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        $payload = json_decode($request->getBody(), true);

        $input = new \App\Application\UseCases\User\CreateUser\Input(
            $payload["name"],
            $payload["email"],
            $payload["password"]
        );
    
        $useCase = new CreateUser($this->userRepository, $this->userFactory);
        $output = $useCase->execute($input);
    
        $response->getBody()->write(json_encode($output->hasErrors() ? $output->errors : $output));
        return $response->withStatus($output->hasErrors() ? 400 : 201);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $uuid = $request->getAttribute("uuid");

        $input = new \App\Application\UseCases\User\LoadUser\Input($uuid);
        $useCase = new LoadUser($this->userRepository, $this->userFactory);
        $output = $useCase->execute($input);
    
        $response->getBody()->write(json_encode($output));
        return $response->withStatus(200);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $payload = json_decode($request->getBody(), true);
        $payload['uuid'] = $request->getAttribute("uuid");
    
        $input = new \App\Application\UseCases\User\UpdateUser\Input(
            $payload["uuid"],
            $payload["name"] ?? null,
            $payload["email"] ?? null,
            $payload["password"] ?? null
        );
    
        $useCase = new UpdateUser($this->userRepository, $this->userFactory);
        $output = $useCase->execute($input);
    
        $response->getBody()->write(json_encode($output->hasErrors() ? $output->errors : $output));
        return $response->withStatus($output->hasErrors() ? 400 : 200);
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $uuid = $request->getAttribute("uuid");

        $input = new \App\Application\UseCases\User\DeleteUser\Input($uuid);
        $useCase = new DeleteUser($this->userRepository);
        $output = $useCase->execute($input);
    
        $response->getBody()->write(json_encode($output->hasErrors() ? $output->errors : $output));
        return $response->withStatus($output->hasErrors() ? 400 : 200);
    }
}