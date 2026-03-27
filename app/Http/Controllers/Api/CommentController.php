<?php

namespace App\Http\Controllers\Api;

use App\DTOS\CommentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Task;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    protected CommentService $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    public function store(StoreCommentRequest $request, Task $task): JsonResponse
    {
        $this->authorize('view', $task);

        $dto = new CommentDTO(
            id: null,
            comment: $request->comment,
            task_id: (int) $task->id,
            user_id: (int) $request->user()->id,
        );

        $comment = $this->commentService->createComment($dto);

        return CommentResource::make($comment->load('user'))
            ->response()
            ->setStatusCode(201);
    }
}
