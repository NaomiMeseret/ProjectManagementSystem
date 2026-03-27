<?php

use App\Enums\ProjectStatus;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

test('manager can create a task for their own project through the web controller', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Portal Refresh',
        'description' => 'Refresh delivery flow.',
        'deadline' => now()->addWeek()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $this->actingAs($manager);

    $this->get(route('projects.tasks.create', $project))
        ->assertOk()
        ->assertSee('Create Task');

    $this->post(route('projects.tasks.store', $project), [
        'title' => 'Build release checklist',
        'description' => 'Prepare the release runbook.',
        'assigned_to' => $developer->id,
        'status' => TaskStatus::TODO->value,
        'priority' => TaskPriority::HIGH->value,
    ])
        ->assertRedirect();

    $this->assertDatabaseHas('tasks', [
        'title' => 'Build release checklist',
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
    ]);
});

test('assigned developer can change task status from the web page', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Reporting Suite',
        'description' => 'Improve team reporting.',
        'deadline' => now()->addDays(8)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Wire project filters',
        'description' => 'Complete the filter panel.',
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    $this->actingAs($developer);

    $this->patch(route('tasks.change-status', $task), [
        'status' => TaskStatus::DONE->value,
    ])
        ->assertRedirect(route('tasks.show', $task));

    expect($task->fresh()->status)->toBe(TaskStatus::DONE);
});

test('authorized user can add a comment from the task page', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Ops Board',
        'description' => 'Prepare the next milestone.',
        'deadline' => now()->addDays(5)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Write deployment notes',
        'description' => 'Capture release notes.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::IN_PROGRESS->value,
    ]);

    $this->actingAs($manager);

    $this->post(route('tasks.comments.store', $task), [
        'comment' => 'Please add rollback details before release.',
    ])
        ->assertRedirect(route('tasks.show', $task));

    $this->assertDatabaseHas('comments', [
        'task_id' => $task->id,
        'user_id' => $manager->id,
        'comment' => 'Please add rollback details before release.',
    ]);
});
