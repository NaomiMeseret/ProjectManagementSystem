<?php

use App\Enums\ProjectStatus;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Filament\Facades\Filament;

test('admin can view activity logs resource page', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $project = Project::create([
        'name' => 'Log Project',
        'description' => 'For activity log page test.',
        'deadline' => now()->addDays(3)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $admin->id,
        'title' => 'Log task',
        'description' => 'For activity log page test.',
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Filament::auth()->login($admin);

    activity()
        ->performedOn($task)
        ->causedBy($admin)
        ->log('Task updated');

    $this->get('/admin/activity-logs')
        ->assertOk()
        ->assertSee('Task updated');
});

test('user can view only own notifications resource page', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Notification Project',
        'description' => 'For notifications page test.',
        'deadline' => now()->addDays(3)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Notification task',
        'description' => 'For notifications page test.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::TODO->value,
    ]);

    $developer->notify(new TaskAssignedNotification($task));

    Filament::auth()->login($developer);

    $this->get('/admin/notifications')
        ->assertOk()
        ->assertSee('A task has been assigned to you.');

    Filament::auth()->login($admin);

    $this->get('/admin/notifications')
        ->assertOk()
        ->assertDontSee('A task has been assigned to you.');
});

test('manager cannot access activity logs resource page', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $project = Project::create([
        'name' => 'Hidden Data Project',
        'description' => 'For manager visibility test.',
        'deadline' => now()->addDays(2)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $admin->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $admin->id,
        'title' => 'Hidden task',
        'description' => 'Should not be visible to manager.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::TODO->value,
    ]);

    activity()
        ->performedOn($task)
        ->causedBy($admin)
        ->log('Task updated');

    Filament::auth()->login($manager);

    $this->get('/admin/activity-logs')
        ->assertForbidden();
});

test('manager cannot access users resource page', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    Filament::auth()->login($manager);

    $this->get('/admin/users')
        ->assertForbidden();
});

test('manager cannot access notifications resource page', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    Filament::auth()->login($manager);

    $this->get('/admin/notifications')
        ->assertForbidden();
});
