<?php 
namespace App\Domain\Factories;

use App\Domain\Entities\User\Encoder;
use App\Domain\Entities\User\User;

class UserFactory
{
    public function __construct(
        private readonly Encoder $encoder
    ) {}

    public function create(string $name, string $email, string $password): User
    {
        $password = $this->encoder->encode($password);
        return User::create($name, $email, $password);
    }

    public function restore(string $uuid, string $name, string $email, string $password, string $createdAt, string $updatedAt): User
    {
        $password = $this->encoder->encode($password);
        return User::restore($uuid, $name, $email, $password, $createdAt, $updatedAt);        
    }
}