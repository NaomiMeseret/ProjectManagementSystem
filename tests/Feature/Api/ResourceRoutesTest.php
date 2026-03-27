<?php

use App\Enums\ProjectStatus;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;

test('guest cannot access protected api project routes', function () {
    $this->getJson('/api/projects')->assertUnauthorized();
});

test('guest request without json headers still gets json for protected api route', function () {
    $response = $this->get('/api/projects');

    $response->assertUnauthorized();

    expect($response->headers->get('Content-Type'))->toContain('application/json');
});

test('manager can fetch projects from the api', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    Project::create([
        'name' => 'API Delivery',
        'description' => 'Project for api listing.',
        'deadline' => now()->addWeek()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    Sanctum::actingAs($manager);

    $this->getJson('/api/projects')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'status', 'created_by'],
            ],
            'links',
            'meta',
        ])
        ->assertJsonPath('data.0.name', 'API Delivery');
});

test('admin can delete a project through the api and receives a success message', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $project = Project::create([
        'name' => 'Project to delete',
        'description' => 'Delete endpoint response test.',
        'deadline' => now()->addWeek()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    Sanctum::actingAs($admin);

    $this->deleteJson("/api/projects/{$project->id}")
        ->assertOk()
        ->assertJson([
            'message' => 'Project deleted successfully.',
        ]);

    $this->assertSoftDeleted('projects', [
        'id' => $project->id,
    ]);
});

test('deleting a project also soft deletes its tasks and comments', function () {
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
        'name' => 'Cascade project delete',
        'description' => 'Soft delete tasks and comments too.',
        'deadline' => now()->addWeek()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Child task',
        'description' => 'Belongs to project.',
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    $comment = Comment::create([
        'task_id' => $task->id,
        'user_id' => $manager->id,
        'comment' => 'Child comment.',
    ]);

    Sanctum::actingAs($admin);

    $this->deleteJson("/api/projects/{$project->id}")
        ->assertOk();

    $this->assertSoftDeleted('projects', [
        'id' => $project->id,
    ]);

    $this->assertSoftDeleted('tasks', [
        'id' => $task->id,
    ]);

    $this->assertSoftDeleted('comments', [
        'id' => $comment->id,
    ]);
});

test('admin can delete a task through the api and receives a success message', function () {
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
        'name' => 'Task delete project',
        'description' => 'Delete task endpoint response test.',
        'deadline' => now()->addWeek()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Task to delete',
        'description' => 'Task delete test.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Sanctum::actingAs($admin);

    $this->deleteJson("/api/projects/{$project->id}/tasks/{$task->id}")
        ->assertOk()
        ->assertJson([
            'message' => 'Task deleted successfully.',
        ]);

    $this->assertSoftDeleted('tasks', [
        'id' => $task->id,
    ]);
});

test('deleting a task also soft deletes its comments', function () {
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
        'name' => 'Cascade task delete',
        'description' => 'Soft delete child comments.',
        'deadline' => now()->addWeek()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Task with comments',
        'description' => 'Will be deleted.',
        'priority' => TaskPriority::HIGH->value,
        'status' => TaskStatus::TODO->value,
    ]);

    $comment = Comment::create([
        'task_id' => $task->id,
        'user_id' => $manager->id,
        'comment' => 'Comment to delete.',
    ]);

    Sanctum::actingAs($admin);

    $this->deleteJson("/api/projects/{$project->id}/tasks/{$task->id}")
        ->assertOk();

    $this->assertSoftDeleted('tasks', [
        'id' => $task->id,
    ]);

    $this->assertSoftDeleted('comments', [
        'id' => $comment->id,
    ]);
});

test('manager can create a task through the nested api route', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Mobile Rollout',
        'description' => 'Nested task creation.',
        'deadline' => now()->addDays(6)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    Notification::fake();

    Sanctum::actingAs($manager);

    $this->postJson("/api/projects/{$project->id}/tasks", [
        'title' => 'Prepare release checklist',
        'description' => 'Checklist for go live.',
        'assigned_to' => $developer->id,
        'status' => TaskStatus::TODO->value,
        'priority' => TaskPriority::HIGH->value,
    ])
        ->assertCreated()
        ->assertJsonPath('data.title', 'Prepare release checklist')
        ->assertJsonPath('data.project.id', $project->id)
        ->assertJsonPath('data.assignee.id', $developer->id);

    Notification::assertSentTo($developer, TaskAssignedNotification::class);
});

test('manager cannot assign task to non developer user', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    $project = Project::create([
        'name' => 'Role Validation Project',
        'description' => 'Validate assignee role.',
        'deadline' => now()->addDays(6)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    Sanctum::actingAs($manager);

    $this->postJson("/api/projects/{$project->id}/tasks", [
        'title' => 'Invalid assignee test',
        'description' => 'Should fail validation.',
        'assigned_to' => $admin->id,
        'status' => TaskStatus::TODO->value,
        'priority' => TaskPriority::MEDIUM->value,
    ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['assigned_to']);
});

test('project creation is stored in activity log', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    Sanctum::actingAs($manager);

    $response = $this->postJson('/api/projects', [
        'name' => 'Audit Trail Project',
        'description' => 'Check project log',
        'deadline' => now()->addDays(5)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
    ])->assertCreated();

    $projectId = $response->json('data.id');

    $this->assertDatabaseHas('activity_log', [
        'subject_type' => (new Project)->getMorphClass(),
        'subject_id' => $projectId,
        'description' => 'Project created',
    ]);
});

test('task update is stored in activity log', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Update Log Project',
        'description' => 'Track task updates',
        'deadline' => now()->addDays(5)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Original task title',
        'description' => 'Before update.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Sanctum::actingAs($manager);

    $this->putJson("/api/projects/{$project->id}/tasks/{$task->id}", [
        'title' => 'Updated task title',
        'description' => 'After update.',
        'assigned_to' => $developer->id,
        'status' => TaskStatus::IN_PROGRESS->value,
        'priority' => TaskPriority::HIGH->value,
    ])->assertOk();

    $this->assertDatabaseHas('activity_log', [
        'subject_type' => $task->getMorphClass(),
        'subject_id' => $task->id,
        'description' => 'Task updated',
    ]);
});

test('assigned developer can change task status through the api', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Status Flow',
        'description' => 'Task status change.',
        'deadline' => now()->addDays(4)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Update progress',
        'description' => 'Move task forward.',
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Sanctum::actingAs($developer);

    $this->patchJson("/api/tasks/{$task->id}/status", [
        'status' => TaskStatus::DONE->value,
    ])
        ->assertOk()
        ->assertJsonPath('data.status', TaskStatus::DONE->value);
});

test('authorized user can post a comment through the api', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Comment Flow',
        'description' => 'Comment creation.',
        'deadline' => now()->addDays(5)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Review release notes',
        'description' => 'Comment route test.',
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::IN_PROGRESS->value,
    ]);

    Sanctum::actingAs($manager);

    $this->postJson("/api/tasks/{$task->id}/comments", [
        'comment' => 'Please add the final deployment note.',
    ])
        ->assertCreated()
        ->assertJsonPath('data.comment', 'Please add the final deployment note.')
        ->assertJsonPath('data.user.id', $manager->id);

    $this->assertDatabaseHas('activity_log', [
        'subject_type' => (new Comment)->getMorphClass(),
        'description' => 'Comment added',
    ]);
});

test('manager cannot view or comment on a task from another managers project', function () {
    $ownerManager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $otherManager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $project = Project::create([
        'name' => 'Private Manager Project',
        'description' => 'Should stay private to its manager.',
        'deadline' => now()->addDays(5)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $ownerManager->id,
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'assigned_to' => $developer->id,
        'title' => 'Manager private task',
        'description' => 'Only owner manager should access.',
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Sanctum::actingAs($otherManager);

    $this->postJson("/api/tasks/{$task->id}/comments", [
        'comment' => 'I should not be able to post this.',
    ])->assertForbidden();
});
