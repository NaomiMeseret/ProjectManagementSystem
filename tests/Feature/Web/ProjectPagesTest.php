<?php

use App\Enums\ProjectStatus;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

test('guests are redirected from project pages', function () {
    $response = $this->get(route('projects.index'));

    $response->assertRedirect(route('login'));
});

test('manager can view project index and create a project from the web flow', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    Project::create([
        'name' => 'Client Migration',
        'description' => 'Move the client workspace to the new stack.',
        'deadline' => now()->addWeek()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $this->actingAs($manager);

    $this->get(route('projects.index'))
        ->assertOk()
        ->assertSee('Projects')
        ->assertSee('Client Migration');

    $this->post(route('projects.store'), [
        'name' => 'Operations Cleanup',
        'description' => 'Refine scope and delivery.',
        'deadline' => now()->addDays(10)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
    ])
        ->assertRedirect();

    $this->assertDatabaseHas('projects', [
        'name' => 'Operations Cleanup',
        'created_by' => $manager->id,
    ]);
});

test('developer cannot open the create project page', function () {
    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $this->actingAs($developer);

    $this->get(route('projects.create'))->assertForbidden();
});

test('developer can view projects that contain tasks assigned to them', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $otherDeveloper = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $visibleProject = Project::create([
        'name' => 'Visible Project',
        'description' => 'Assigned to current developer.',
        'deadline' => now()->addDays(7)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $hiddenProject = Project::create([
        'name' => 'Hidden Project',
        'description' => 'Assigned to another developer.',
        'deadline' => now()->addDays(9)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    Task::create([
        'project_id' => $visibleProject->id,
        'assigned_to' => $developer->id,
        'title' => 'My task',
        'description' => 'Assigned to me.',
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Task::create([
        'project_id' => $hiddenProject->id,
        'assigned_to' => $otherDeveloper->id,
        'title' => 'Other task',
        'description' => 'Assigned to someone else.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::TODO->value,
    ]);

    $this->actingAs($developer);

    $this->get(route('projects.index'))
        ->assertOk()
        ->assertSee('Visible Project')
        ->assertDontSee('Hidden Project');
});
