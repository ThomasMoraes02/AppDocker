<?php 
namespace App\Application\UseCases\User\LoadUser;

class Output
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $email,
        public string $password,
        public string $createdAt,
        public string $updatedAt
    ) {}
}