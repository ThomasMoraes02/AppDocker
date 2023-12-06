<?php 
namespace App\Domain\Entities\User;

interface Encoder
{
    public function encode(string $password): string;

    public function decode(string $password, string $hash): bool;
}