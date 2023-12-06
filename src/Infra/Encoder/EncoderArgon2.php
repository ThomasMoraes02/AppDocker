<?php 
namespace App\Infra\Encoder;

use App\Domain\Entities\User\Encoder;

class EncoderArgon2 implements Encoder
{
    public function encode(string $password): string
    {
        if(isset(password_get_info($password)['algo'])) {
            return $password;
        }

        return password_hash($password, PASSWORD_ARGON2ID);
    }

    public function decode(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}