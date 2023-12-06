<?php 
namespace App\Application\UseCases\User\LoadUser;

class Input
{
    public function __construct(
        public string $uuid,
    ) {}
}