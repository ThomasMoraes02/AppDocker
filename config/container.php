<?php

use DI\ContainerBuilder;
use App\Domain\Factories\UserFactory;
use App\Infra\Encoder\EncoderArgon2;
use App\Infra\Repositories\UserRepositoryMysql;

use function DI\create;
use function DI\get;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    "PDO" => function(): PDO {
        $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        return $pdo;
    },
    "Encoder" => create(EncoderArgon2::class),
    "UserFactory" => create(UserFactory::class)->constructor(get("Encoder")),
    "UserRepository" => create(UserRepositoryMysql::class)->constructor(get('PDO'), get('UserFactory'))
]);
return $containerBuilder->build();