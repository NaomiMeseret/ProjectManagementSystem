<?php

namespace App\Http\Controllers\Web;

use App\DTOS\CommentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Task;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function __construct(protected CommentService $commentService) {}

    public function store(StoreCommentRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('view', $task);

        $user = $request->user();

        abort_unless($user !== null, 401);

        $dto = new CommentDTO(
            id: null,
            comment: $request->comment,
            task_id: (int) $task->id,
            user_id: (int) $user->id,
        );

        $this->commentService->createComment($dto);

        return redirect()
            ->route('tasks.show', $task)
            ->with('status', 'Comment added successfully.');
    }
}
