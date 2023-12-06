<?php 
namespace App\Application\UseCases\User\DeleteUser;

class Input
{
    public function __construct(public readonly string $uuid) {}
}