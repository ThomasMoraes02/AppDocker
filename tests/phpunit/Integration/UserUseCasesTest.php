<?php 
namespace App\Test\phpunit\Integration;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\User\User;
use App\Infra\Encoder\EncoderArgon2;
use App\Domain\Factories\UserFactory;
use App\Application\Repositories\UserRepository;
use App\Infra\Repositories\UserRepositoryMemory;
use App\Application\UseCases\User\CreateUser\CreateUser;
use App\Application\UseCases\User\DeleteUser\DeleteUser;
use App\Application\UseCases\User\UpdateUser\UpdateUser;

class UserUseCasesTest extends TestCase
{
    public static UserRepository $userRepository;

    public static UserFactory $userFactory;

    public User $user;

    public static function setUpBeforeClass(): void
    {
        self::$userRepository = new UserRepositoryMemory();
        self::$userFactory = new UserFactory(new EncoderArgon2());
    }

    protected function setUp(): void
    {
        $input = new \App\Application\UseCases\User\CreateUser\Input(
            'Thomas Moraes',
            'thomas@gmail.com',
            '123456'
        );

        $useCase = new CreateUser(self::$userRepository, self::$userFactory);
        $output = $useCase->execute($input);

        $this->user = self::$userRepository->userOfUuid($output->uuid);
    }

    public function test_must_create_user()
    {
        $this->assertInstanceOf(User::class, $this->user);
        $this->assertEquals('Thomas Moraes', $this->user->name);
        $this->assertEquals('thomas@gmail.com', $this->user->email);
    }

    public function test_must_update_user()
    {
        $input = new \App\Application\UseCases\User\UpdateUser\Input(
            $this->user->uuid,
            'Thomas Vinicius de Moraes'
        );

        $useCase = new UpdateUser(self::$userRepository, self::$userFactory);
        $output = $useCase->execute($input);

        $this->assertEquals('Thomas Vinicius de Moraes', $output->name);
    }

    public function test_must_delete_user()
    {
        $input = new \App\Application\UseCases\User\DeleteUser\Input(
            $this->user->uuid
        );

        $useCase = new DeleteUser(self::$userRepository);
        $output = $useCase->execute($input);

        $this->assertEquals('User deleted', $output->message);
    }
}