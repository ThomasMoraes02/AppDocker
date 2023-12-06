<?php 
namespace App\Application\Repositories;

use App\Domain\Entities\Email;
use App\Domain\Entities\User\User;

interface UserRepository
{
    public function save(User $user): void;

    public function userOfUuid(string $uuid): ?User;

    public function userOfEmail(Email $email): ?User;

    public function delete(string $uuid): void;

    public function update(User $user): void;
}