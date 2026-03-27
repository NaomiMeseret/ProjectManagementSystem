<?php

namespace App\Http\Controllers\Api;

use App\DTOS\TaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeTaskStatusRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskService $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    public function store(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $this->authorize('create', [Task::class, $project]);

        $dto = new TaskDTO(
            null,
            $request->title,
            $request->description,
            (int) $project->id,
            (int) $request->assigned_to,
            TaskStatus::from($request->status),
            TaskPriority::from($request->priority),
        );

        $task = $this->taskService->createTask($dto);

        return TaskResource::make($task->load(['project', 'assignee']))
            ->response()
            ->setStatusCode(201);
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Task::class);

        $user = $request->user();

        abort_unless($user !== null, 401);

        $tasks = $this->taskService->listTasksForUser($user);

        return TaskResource::collection($tasks)->response();
    }

    public function update(UpdateTaskRequest $request, Project $project, Task $task): JsonResponse
    {
        abort_unless($task->project_id === $project->id, 404);

        $this->authorize('update', $task);

        $dto = new TaskDTO(
            id: $task->id,
            title: $request->title ?? $task->title,
            description: $request->description ?? $task->description,
            project_id: (int) $project->id,
            assigned_to: (int) ($request->assigned_to ?? $task->assigned_to),
            status: $request->filled('status') ? TaskStatus::from($request->status) : $task->status,
            priority: $request->filled('priority') ? TaskPriority::from($request->priority) : $task->priority,
        );

        $updatedTask = $this->taskService->updateTask($task, $dto);

        return TaskResource::make($updatedTask->load(['project', 'assignee']))->response();
    }

    public function changeStatus(ChangeTaskStatusRequest $request, Task $task): JsonResponse
    {
        $this->authorize('changeStatus', $task);

        $updatedTask = $this->taskService->changeTaskStatus(
            $task,
            TaskStatus::from($request->status),
        );

        return TaskResource::make($updatedTask->load(['project', 'assignee']))->response();
    }

    public function destroy(Project $project, Task $task): JsonResponse
    {
        abort_unless($task->project_id === $project->id, 404);

        $this->authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return response()->json([
            'message' => 'Task deleted successfully.',
        ]);
    }
}
