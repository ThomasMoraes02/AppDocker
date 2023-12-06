<?php

use App\Domain\Entities\User\User;
use App\Infra\Encoder\EncoderArgon2;
use App\Domain\Factories\UserFactory;
use App\Infra\Repositories\UserRepositoryMemory;
use App\Application\UseCases\User\CreateUser\CreateUser;
use App\Application\UseCases\User\DeleteUser\DeleteUser;
use App\Application\UseCases\User\UpdateUser\UpdateUser;


beforeEach(function() {
    $this->userFactory = new UserFactory(new EncoderArgon2());
    $this->userRepository = new UserRepositoryMemory();
});


test('must_create_user', function () {
    $input = new \App\Application\UseCases\User\CreateUser\Input(
        'Thomas Moraes',
        'thomas@gmail.com',
        '123456'
    );
    
    $useCase = new CreateUser($this->userRepository, $this->userFactory);
    $output = $useCase->execute($input);
    
    $user = $this->userRepository->userOfUuid($output->uuid);

    expect($user)->toHaveProperties([
        'uuid' => $output->uuid,
        'name' => 'Thomas Moraes',
        'email' => 'thomas@gmail.com'
    ]);

    return ['user' => $user, 'userRepository' => $this->userRepository];
});


test('must_update_user', function (array $data) {
    $user = $data['user'];
    $this->userRepository = $data['userRepository'];

    $input = new \App\Application\UseCases\User\UpdateUser\Input(
        $user->uuid,
        'Thomas Vinicius de Moraes'
    );

    $useCase = new UpdateUser($this->userRepository, $this->userFactory);
    $output = $useCase->execute($input);

    expect($output->name)->toBe('Thomas Vinicius de Moraes');
})->depends('must_create_user');


test('must_delete_user', function (array $data) {
    $user = $data['user'];
    $this->userRepository = $data['userRepository'];

    $input = new \App\Application\UseCases\User\DeleteUser\Input(
        $user->uuid
    );

    $useCase = new DeleteUser($this->userRepository);
    $output = $useCase->execute($input);

    expect($output->message)->toBe('User deleted');
    expect($this->userRepository->userOfUuid($user->uuid))->toBeNull();
})->depends('must_create_user');