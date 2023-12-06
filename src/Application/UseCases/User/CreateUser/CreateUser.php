<?php 
namespace App\Application\UseCases\User\CreateUser;

use App\Domain\Factories\UserFactory;
use App\Application\Repositories\UserRepository;
use App\Domain\Entities\Email;

class CreateUser
{
    public function __construct(private readonly UserRepository $userRepository, private readonly UserFactory $userFactory) {}

    /**
     * Create new User
     *
     * @param Input $input
     * @return Output
     */
    public function execute(Input $input): Output
    {
        $output = new Output();
        if($this->userRepository->userOfEmail(new Email($input->email))) {
            return $output->addError("Email already in use");
        }

        $user = $this->userFactory->create(
            $input->name,
            $input->email,
            $input->password
        );

        $this->userRepository->save($user);

        return new Output($user->uuid ?? null);
    }
}