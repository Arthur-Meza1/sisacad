<?php

namespace App\Application\Admin\DTOs;

final readonly class NewUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $role,
    ) {}

    public static function create(
        string $name,
        string $email,
        string $password,
        string $role,
    ): self {
        return new self($name, $email, $password, $role);
    }
}
