<?php

namespace App\Http\Controllers\Api;

use App\DTOS\ProjectDTO;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected ProjectService $projectService;
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $this->authorize('create', Project::class);

        $dto = new ProjectDTO(
            id: null,
            name: $request->name,
            description: $request->description,
            status: ProjectStatus::from($request->status),
            deadline: $request->deadline,
        );

        $project = $this->projectService->createProject($dto, (int) $request->user()->id);

        return ProjectResource::make($project->load('creator'))
            ->response()
            ->setStatusCode(201);
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Project::class);

        $user = $request->user();

        abort_unless($user !== null, 401);

        $projects = $this->projectService->listProjectsForUser($user);

        return ProjectResource::collection($projects)->response();
    }

    public function show(Project $project): JsonResponse
    {
        $this->authorize('view', $project);

        return ProjectResource::make($project->load('creator'))->response();
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $this->authorize('update', $project);

        $dto = new ProjectDTO(
            id: $project->id,
            name: $request->name ?? $project->name,
            description: $request->description ?? $project->description,
            status: $request->filled('status') ? ProjectStatus::from($request->status) : $project->status,
            deadline: $request->deadline ?? $project->deadline,
        );

        $updatedProject = $this->projectService->updateProject($project, $dto);

        return ProjectResource::make($updatedProject->load('creator'))->response();
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->authorize('delete', $project);

        $this->projectService->deleteProject($project);

        return response()->json([
            'message' => 'Project deleted successfully.',
        ]);
    }
}
