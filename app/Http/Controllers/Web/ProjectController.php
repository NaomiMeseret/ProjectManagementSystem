<?php

namespace App\Http\Controllers\Web;

use App\DTOS\ProjectDTO;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Project::class);

        $user = $request->user();

        abort_unless($user !== null, 401);

        return view('projects.index', [
            'projects' => $this->projectService->listProjectsForUser($user),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Project::class);

        return view('projects.create', [
            'statuses' => ProjectStatus::cases(),
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->authorize('create', Project::class);

        $user = $request->user();

        abort_unless($user !== null, 401);

        $dto = new ProjectDTO(
            id: null,
            name: $request->name,
            description: $request->description,
            status: ProjectStatus::from($request->status),
            deadline: $request->deadline,
        );

        $project = $this->projectService->createProject($dto, (int) $user->id);

        return redirect()
            ->route('projects.show', $project)
            ->with('status', 'Project created successfully.');
    }

    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        $project->load([
            'creator',
            'tasks' => function ($taskQuery): void {
                $taskQuery
                    ->with('assignee')
                    ->withCount('comments')
                    ->latest();
            },
        ]);

        return view('projects.show', [
            'project' => $project,
        ]);
    }

    public function edit(Project $project): View
    {
        $this->authorize('update', $project);

        return view('projects.edit', [
            'project' => $project,
            'statuses' => ProjectStatus::cases(),
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
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

        return redirect()
            ->route('projects.show', $updatedProject)
            ->with('status', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        $this->projectService->deleteProject($project);

        return redirect()
            ->route('projects.index')
            ->with('status', 'Project deleted successfully.');
    }
}
