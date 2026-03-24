<?php

namespace App\DTOS;
use App\Enums\UserRole;

class UserDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string $password,
        public UserRole $role,
    ) {}
}   