<?php 
namespace App\Infra\Repositories;

use PDO;
use App\Domain\Entities\Email;
use App\Domain\Entities\User\User;
use App\Application\Repositories\UserRepository;
use App\Domain\Factories\UserFactory;

class UserRepositoryMysql implements UserRepository
{
    public function __construct(private readonly PDO $pdo, private readonly UserFactory $userFactory) {}

    public function save(User $user): void
    {
        $insert = "INSERT INTO users (uuid, name, email, password, created_at, updated_at) VALUES (:uuid, :name, :email, :password, :created_at, :updated_at)";
        $stmt = $this->pdo->prepare($insert);

        $stmt->bindValue(':uuid', $user->uuid);
        $stmt->bindValue(':name', $user->name);
        $stmt->bindValue(':email', $user->email);
        $stmt->bindValue(':password', $user->password);
        $stmt->bindValue(':created_at', $user->createdAt->format('Y-m-d H:i:s'));
        $stmt->bindValue(':updated_at', $user->updatedAt->format('Y-m-d H:i:s'));

        $stmt->execute();
    }

    public function userOfUuid(string $uuid): ?User
    {
        $query = "SELECT * FROM users WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':uuid', $uuid);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$user) return null;

        return $this->userFactory->restore(
            $user['uuid'],
            $user['name'],
            $user['email'],
            $user['password'],
            $user['created_at'],
            $user['updated_at']
        );
    }

    public function userOfEmail(Email $email): ?User
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email->__toString());
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$user) return null;

        return $this->userFactory->restore(
            $user['uuid'],
            $user['name'],
            $user['email'],
            $user['password'],
            $user['created_at'],
            $user['updated_at']
        );
    }

    public function delete(string $uuid): void
    {
        $query = "DELETE FROM users WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':uuid', $uuid);
        $stmt->execute();
    }

    public function update(User $user): void
    {
        $update = "UPDATE users SET name = :name, email = :email, password = :password, updated_at = :updated_at WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($update);

        $stmt->bindValue(':uuid', $user->uuid);
        $stmt->bindValue(':name', $user->name);
        $stmt->bindValue(':email', $user->email);
        $stmt->bindValue(':password', $user->password);
        $stmt->bindValue(':updated_at', $user->updatedAt->format('Y-m-d H:i:s'));

        $stmt->execute();
    }

    public function list(): array
    {
        $query = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = array_map(fn($user) => $this->userFactory->restore(
            $user['uuid'],
            $user['name'],
            $user['email'],
            $user['password'],
            $user['created_at'],
            $user['updated_at']
        ), $users);

        return array_map(fn($user) => [
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => (string) $user->email,
            'password' => (string) $user->password,
            'created_at' => $user->createdAt->format('d/m/Y - H:i:s'),
            'updated_at' => $user->updatedAt->format('d/m/Y - H:i:s'),
        ], $users);
    }
}