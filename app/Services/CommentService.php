<?php

namespace App\Services;

use App\DTOS\CommentDTO;
use App\Models\Comment;

class CommentService
{
    public function createComment(CommentDTO $dto): Comment
    {
        $comment = Comment::create([
            'comment' => $dto->comment,
            'task_id' => $dto->task_id,
            'user_id' => $dto->user_id,
        ]);

        activity()
            ->performedOn($comment)
            ->causedBy(auth()->user())
            ->log('Comment added');

        return $comment;
    }
}
