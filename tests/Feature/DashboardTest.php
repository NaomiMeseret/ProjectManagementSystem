<?php

use App\Enums\ProjectStatus;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('dashboard shows real database metrics for manager scope', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $otherManager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $ownProject = Project::create([
        'name' => 'Manager Delivery Project',
        'description' => 'Visible in dashboard',
        'deadline' => now()->addDays(2)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $otherProject = Project::create([
        'name' => 'Hidden Project',
        'description' => 'Should not be visible to manager dashboard',
        'deadline' => now()->addDays(10)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $otherManager->id,
    ]);

    Task::create([
        'project_id' => $ownProject->id,
        'assigned_to' => $developer->id,
        'title' => 'Pending task',
        'description' => null,
        'priority' => TaskPriority::HIGH->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Task::create([
        'project_id' => $ownProject->id,
        'assigned_to' => $developer->id,
        'title' => 'Done task',
        'description' => null,
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::DONE->value,
    ]);

    Task::create([
        'project_id' => $otherProject->id,
        'assigned_to' => $developer->id,
        'title' => 'Other manager task',
        'description' => null,
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    $this->actingAs($manager);

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Manager Delivery Project')
        ->assertDontSee('Hidden Project')
        ->assertSee('1')
        ->assertSee('2');
});
