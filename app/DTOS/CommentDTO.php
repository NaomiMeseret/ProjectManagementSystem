<?php

namespace App\DTOS;


class CommentDTO
{
    public function __construct(
        public ?int $id,
        public string $comment,
        public int $task_id,
        public int $user_id,
    ) {}
}