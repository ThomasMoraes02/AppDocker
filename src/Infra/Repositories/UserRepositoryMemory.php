<?php 
namespace App\Infra\Repositories;

use App\Application\Repositories\UserRepository;
use App\Domain\Entities\Email;
use App\Domain\Entities\User\User;

class UserRepositoryMemory implements UserRepository
{
    public function __construct(private array $users = []) {}

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function userOfUuid(string $uuid): ?User
    {
        $user = array_filter($this->users, fn(User $user) => $user->uuid === $uuid);
        return array_shift($user) ?? null; 
    }

    public function userOfEmail(Email $email): ?User
    {
        $user = array_filter($this->users, fn(User $user) => $user->email === $email);
        return array_shift($user) ?? null;
    }

    public function update(User $user): void
    {
        $key = array_search($user, $this->users, true);
        $this->users[$key] = $user;
    }

    public function delete(string $uuid): void
    {
        $key = array_search($this->userOfUuid($uuid), $this->users, true);
        unset($this->users[$key]);
    }

    public function list(): array
    {
        return $this->users;
    }
}