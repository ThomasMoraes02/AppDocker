<?php 
namespace App\Application\UseCases\User\CreateUser;

class Input
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}