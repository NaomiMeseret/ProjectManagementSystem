<?php

use App\Enums\ProjectStatus;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Filament\Widgets\ProjectStatsOverview;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

test('admin sees global dashboard stats in the project stats widget', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $projectA = Project::create([
        'name' => 'Project A',
        'description' => 'A',
        'deadline' => now()->addDay()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $projectB = Project::create([
        'name' => 'Project B',
        'description' => 'B',
        'deadline' => now()->addDays(2)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $admin->id,
    ]);

    Task::create([
        'project_id' => $projectA->id,
        'assigned_to' => $developer->id,
        'title' => 'Done task',
        'description' => null,
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::DONE->value,
    ]);

    Task::create([
        'project_id' => $projectA->id,
        'assigned_to' => $developer->id,
        'title' => 'Todo task',
        'description' => null,
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Task::create([
        'project_id' => $projectB->id,
        'assigned_to' => $developer->id,
        'title' => 'Done task B',
        'description' => null,
        'priority' => TaskPriority::HIGH->value,
        'status' => TaskStatus::DONE->value,
    ]);

    $this->actingAs($admin);

    expect(widgetStatValues())->toBe([
        'Total Projects' => '2',
        'Total Tasks' => '3',
        'Completed Tasks' => '2',
    ]);
});

test('manager sees only own project stats in the project stats widget', function () {
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
        'name' => 'Own Project',
        'description' => 'Own',
        'deadline' => now()->addDay()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $otherProject = Project::create([
        'name' => 'Other Project',
        'description' => 'Other',
        'deadline' => now()->addDays(2)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $otherManager->id,
    ]);

    Task::create([
        'project_id' => $ownProject->id,
        'assigned_to' => $developer->id,
        'title' => 'Own done',
        'description' => null,
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::DONE->value,
    ]);

    Task::create([
        'project_id' => $ownProject->id,
        'assigned_to' => $developer->id,
        'title' => 'Own todo',
        'description' => null,
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Task::create([
        'project_id' => $otherProject->id,
        'assigned_to' => $developer->id,
        'title' => 'Other done',
        'description' => null,
        'priority' => TaskPriority::HIGH->value,
        'status' => TaskStatus::DONE->value,
    ]);

    $this->actingAs($manager);

    expect(widgetStatValues())->toBe([
        'Total Projects' => '1',
        'Total Tasks' => '2',
        'Completed Tasks' => '1',
    ]);
});

test('developer sees only assigned task stats in the project stats widget', function () {
    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $otherDeveloper = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $projectA = Project::create([
        'name' => 'Project A',
        'description' => 'A',
        'deadline' => now()->addDay()->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    $projectB = Project::create([
        'name' => 'Project B',
        'description' => 'B',
        'deadline' => now()->addDays(2)->toDateString(),
        'status' => ProjectStatus::ACTIVE->value,
        'created_by' => $manager->id,
    ]);

    Task::create([
        'project_id' => $projectA->id,
        'assigned_to' => $developer->id,
        'title' => 'Dev done A',
        'description' => null,
        'priority' => TaskPriority::LOW->value,
        'status' => TaskStatus::DONE->value,
    ]);

    Task::create([
        'project_id' => $projectA->id,
        'assigned_to' => $developer->id,
        'title' => 'Dev todo A',
        'description' => null,
        'priority' => TaskPriority::MEDIUM->value,
        'status' => TaskStatus::TODO->value,
    ]);

    Task::create([
        'project_id' => $projectB->id,
        'assigned_to' => $developer->id,
        'title' => 'Dev done B',
        'description' => null,
        'priority' => TaskPriority::HIGH->value,
        'status' => TaskStatus::DONE->value,
    ]);

    Task::create([
        'project_id' => $projectB->id,
        'assigned_to' => $otherDeveloper->id,
        'title' => 'Other developer task',
        'description' => null,
        'priority' => TaskPriority::HIGH->value,
        'status' => TaskStatus::DONE->value,
    ]);

    $this->actingAs($developer);

    expect(widgetStatValues())->toBe([
        'Total Projects' => '2',
        'Total Tasks' => '3',
        'Completed Tasks' => '2',
    ]);
});

function widgetStatValues(): array
{
    $widget = app(ProjectStatsOverview::class);
    $method = new ReflectionMethod($widget, 'getStats');
    $method->setAccessible(true);

    $stats = $method->invoke($widget);
    $values = [];

    foreach ($stats as $stat) {
        $values[$stat->getLabel()] = (string) $stat->getValue();
    }

    return $values;
}
