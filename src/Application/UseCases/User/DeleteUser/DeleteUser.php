<?php 
namespace App\Application\UseCases\User\DeleteUser;

use App\Application\Repositories\UserRepository;
use App\Application\UseCases\User\DeleteUser\Input;
use App\Application\UseCases\User\DeleteUser\Output;

class DeleteUser
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function execute(Input $input): Output
    {
        $output = new Output();
        if(!$this->userRepository->userOfUuid($input->uuid)) {
            return $output->addError('User not found');
        }

        $this->userRepository->delete($input->uuid);

        return new Output('User deleted');
    }
}