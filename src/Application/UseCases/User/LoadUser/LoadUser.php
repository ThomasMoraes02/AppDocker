<?php 
namespace App\Application\UseCases\User\LoadUser;

use InvalidArgumentException;
use App\Domain\Factories\UserFactory;
use App\Application\Repositories\UserRepository;
use App\Application\UseCases\User\LoadUser\Input;
use App\Application\UseCases\User\LoadUser\Output;

class LoadUser
{
    public function __construct(private readonly UserRepository $userRepository, private readonly UserFactory $userFactory) {}

    public function execute(Input $input): Output
    {
        if(!$user = $this->userRepository->userOfUuid($input->uuid)) throw new InvalidArgumentException('User not found');
        
        return new Output(
            $user->uuid,
            $user->name,
            $user->email->__toString(),
            $user->password,
            $user->createdAt->format('d/m/Y H:i:s'),
            $user->updatedAt->format('d/m/Y H:i:s')
        );
    }
}