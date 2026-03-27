<?php

use App\Enums\ProjectStatus;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Facades\Filament;

test('developer cannot access users resource page', function () {
    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    Filament::auth()->login($developer);

    $this->get('/admin/users')
        ->assertForbidden();
});

test('manager sees comments only for tasks inside their projects', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $otherManager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $ownProject = Project::create([
        'name' => 'Manager Own Project',
        'description' => 'Own project comments should be visible.',
        'deadline' => now()->addDays(4)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $otherProject = Project::create([
        'name' => 'Other Project',
        'description' => 'Other manager project comments should be hidden.',
        'deadline' => now()->addDays(4)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $otherManager->id,
    ]);

    $ownTask = Task::create([
        'project_id' => $ownProject->id,
        'assigned_to' => $developer->id,
        'title' => 'Own manager task',
        'description' => 'Task in own project.',
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    $otherTask = Task::create([
        'project_id' => $otherProject->id,
        'assigned_to' => $developer->id,
        'title' => 'Other manager task',
        'description' => 'Task in other project.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Comment::create([
        'task_id' => $ownTask->id,
        'user_id' => $manager->id,
        'comment' => 'Visible manager comment',
    ]);

    Comment::create([
        'task_id' => $otherTask->id,
        'user_id' => $otherManager->id,
        'comment' => 'Hidden manager comment',
    ]);

    Filament::auth()->login($manager);

    $this->get('/admin/comments')
        ->assertOk()
        ->assertSee('Visible manager comment')
        ->assertDontSee('Hidden manager comment');
});

test('developer sees comments only for tasks assigned to them', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $otherDeveloper = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Developer Visibility Project',
        'description' => 'Developer comment visibility test.',
        'deadline' => now()->addDays(4)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $myTask = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'My assigned task',
        'description' => 'Developer assigned task.',
        'priority' => TaskPriority::HIGH->value,
        'status' => TaskStatus::IN_PROGRESS->value,
    ]);

    $otherTask = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $otherDeveloper->id,
        'title' => 'Other assigned task',
        'description' => 'Another developer task.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Comment::create([
        'task_id' => $myTask->id,
        'user_id' => $manager->id,
        'comment' => 'Visible developer comment',
    ]);

    Comment::create([
        'task_id' => $otherTask->id,
        'user_id' => $manager->id,
        'comment' => 'Hidden developer comment',
    ]);

    Filament::auth()->login($developer);

    $this->get('/admin/comments')
        ->assertOk()
        ->assertSee('Visible developer comment')
        ->assertDontSee('Hidden developer comment');
});
