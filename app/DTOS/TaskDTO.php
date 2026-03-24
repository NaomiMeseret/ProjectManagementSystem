<?php

namespace App\DTOS;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;

class TaskDTO
{
    public function __construct(
        public ?int $id,
        public string $title,
        public ?string $description,
        public int $project_id,
        public int $assigned_to,
        public TaskStatus $status,
        public TaskPriority $priority,
    ) {}
}
