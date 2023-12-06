<?php 
namespace App\Application\UseCases\User\UpdateUser;

class Output
{
    public array $errors = [];

    public function __construct(
        public ?string $uuid = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
    ) {}

    public function addError(string $message): self
    {
        $this->errors['errors'][] = $message;
        return $this;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }
}