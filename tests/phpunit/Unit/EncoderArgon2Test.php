<?php 
namespace App\Test\phpunit\Unit;

use App\Infra\Encoder\EncoderArgon2;
use PHPUnit\Framework\TestCase;

class EncoderArgon2Test extends TestCase
{
    public function test_must_encode_password()
    {
        $encoder = new EncoderArgon2();
        $passwordHash = $encoder->encode('123456');

        $this->assertIsString($passwordHash);
    }

    public function test_must_decode_password()
    {
        $encoder = new EncoderArgon2();
        $passwordHash = $encoder->encode('123456');

        $this->assertTrue($encoder->decode('123456', $passwordHash));
    }
}