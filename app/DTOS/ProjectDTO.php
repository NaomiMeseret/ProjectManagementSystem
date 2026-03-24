<?php

namespace App\DTOS;

use App\Enums\ProjectStatus;

class ProjectDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public ProjectStatus $status,
        public ?string $deadline = null,
    ) {}
}
