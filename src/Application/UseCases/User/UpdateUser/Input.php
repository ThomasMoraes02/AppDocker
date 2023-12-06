<?php 
namespace App\Application\UseCases\User\UpdateUser;

class Input
{
    public function __construct(
        public readonly string $uuid,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null
    ) {}
}