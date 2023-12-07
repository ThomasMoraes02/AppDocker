<?php

use App\Infra\Encoder\EncoderArgon2;

$encoder = new EncoderArgon2();

test('must_encode_password', function () use ($encoder) {
    $passwordHash = $encoder->encode('123456');
    expect($passwordHash)->toBeString();
});

test('must_decode_password', function () use ($encoder) {
    $passwordHash = $encoder->encode('123456'); 
    expect($encoder->decode('123456', $passwordHash))->toBeTrue();
});