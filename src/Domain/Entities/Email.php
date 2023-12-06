<?php 
namespace App\Domain\Entities;

use InvalidArgumentException;

class Email
{
    public function __construct(private readonly string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new InvalidArgumentException('Email inválido');
    }

    public function __toString(): string
    {
        return $this->email;
    }
}