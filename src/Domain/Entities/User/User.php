<?php 
namespace App\Domain\Entities\User;

use DateTimeZone;
use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use DateTimeInterface;
use App\Domain\Entities\Email;

class User
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly Email $email,
        private readonly string $password,
        private readonly DateTimeInterface $createdAt,
        private readonly DateTimeInterface $updatedAt
    ) {}

    /**
     * Create new User
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function create(string $name, string $email, string $password): User
    {
        return new User(
            Uuid::uuid4(),
            $name, 
            new Email($email),
            $password,
            new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')),
            new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo'))
        );
    }

    /**
     * Restore User
     *
     * @param string $uuid
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $createdAt
     * @param string $updatedAt
     * @return User
     */
    public static function restore(string $uuid, string $name, string $email, string $password, string $createdAt, string $updatedAt): User
    {
        return new User(
            $uuid,
            $name,
            new Email($email),
            $password,
            new DateTimeImmutable($createdAt),
            new DateTimeImmutable($updatedAt)
        );
    }

    public function __get($name): mixed
    {
        return $this->$name;
    }
}