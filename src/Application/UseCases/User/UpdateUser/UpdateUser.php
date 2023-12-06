<?php 
namespace App\Application\UseCases\User\UpdateUser;

use DateTimeImmutable;
use DateTimeZone;
use App\Domain\Factories\UserFactory;
use App\Application\Repositories\UserRepository;
use App\Application\UseCases\User\UpdateUser\Input;
use App\Application\UseCases\User\UpdateUser\Output;

class UpdateUser
{
    public function __construct(private readonly UserRepository $userRepository, private readonly UserFactory $userFactory) {}

    public function execute(Input $input): Output
    {
        $output = new Output();
        if(!$user = $this->userRepository->userOfUuid($input->uuid)) {
            return $output->addError('User not found');
        }

        $now = new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo'));
        $now = $now->format('Y-m-d H:i:s');

        $user = $this->userFactory->restore(
            $input->uuid,
            $input->name ?? $user->name,
            $input->email ?? $user->email,
            $input->password ?? $user->password,
            $user->createdAt->format('Y-m-d H:i:s'),
            $now
        );

        $this->userRepository->update($user);

        return new Output(
            $user->uuid,
            $user->name,
            $user->email,
            $user->password,
        );
    }
}