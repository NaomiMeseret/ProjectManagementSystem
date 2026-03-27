<?php

use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;

test('task view is allowed for admin owner manager and assigned developer only', function () {
    $policy = new TaskPolicy();

    $project = new Project();
    $project->created_by = 10;

    $task = new Task();
    $task->assigned_to = 22;
    $task->setRelation('project', $project);

    $ownerManager = new User();
    $ownerManager->id = 10;
    $ownerManager->role = UserRole::MANAGER;

    $otherManager = new User();
    $otherManager->id = 7;
    $otherManager->role = UserRole::MANAGER;

    $admin = new User();
    $admin->id = 99;
    $admin->role = UserRole::ADMIN;

    $assignedDeveloper = new User();
    $assignedDeveloper->id = 22;
    $assignedDeveloper->role = UserRole::DEVELOPER;

    $otherDeveloper = new User();
    $otherDeveloper->id = 77;
    $otherDeveloper->role = UserRole::DEVELOPER;

    expect($policy->view($ownerManager, $task))->toBeTrue()
        ->and($policy->view($otherManager, $task))->toBeFalse()
        ->and($policy->view($admin, $task))->toBeTrue()
        ->and($policy->view($assignedDeveloper, $task))->toBeTrue()
        ->and($policy->view($otherDeveloper, $task))->toBeFalse();
});

test('task create is allowed only for manager on own project', function () {
    $policy = new TaskPolicy();

    $project = new Project();
    $project->created_by = 5;

    $ownerManager = new User();
    $ownerManager->id = 5;
    $ownerManager->role = UserRole::MANAGER;

    $otherManager = new User();
    $otherManager->id = 7;
    $otherManager->role = UserRole::MANAGER;

    $admin = new User();
    $admin->id = 5;
    $admin->role = UserRole::ADMIN;

    expect($policy->create($ownerManager, $project))->toBeTrue()
        ->and($policy->create($otherManager, $project))->toBeFalse()
        ->and($policy->create($admin, $project))->toBeFalse();
});

test('task create without project context is allowed for manager only', function () {
    $policy = new TaskPolicy();

    $manager = new User();
    $manager->id = 5;
    $manager->role = UserRole::MANAGER;

    $admin = new User();
    $admin->id = 9;
    $admin->role = UserRole::ADMIN;

    $developer = new User();
    $developer->id = 10;
    $developer->role = UserRole::DEVELOPER;

    expect($policy->create($manager))->toBeTrue()
        ->and($policy->create($admin))->toBeFalse()
        ->and($policy->create($developer))->toBeFalse();
});

test('general update is allowed for admin and project owner manager only', function () {
    $policy = new TaskPolicy();

    $project = new Project();
    $project->created_by = 10;

    $task = new Task();
    $task->assigned_to = 10;
    $task->setRelation('project', $project);

    $ownerManager = new User();
    $ownerManager->id = 10;
    $ownerManager->role = UserRole::MANAGER;

    $otherManager = new User();
    $otherManager->id = 7;
    $otherManager->role = UserRole::MANAGER;

    $admin = new User();
    $admin->role = UserRole::ADMIN;

    $developer = new User();
    $developer->role = UserRole::DEVELOPER;
    $developer->id = 10;

    expect($policy->update($ownerManager, $task))->toBeTrue()
        ->and($policy->update($otherManager, $task))->toBeFalse()
        ->and($policy->update($admin, $task))->toBeTrue()
        ->and($policy->update($developer, $task))->toBeFalse();
});

test('change status is allowed only for assigned developer', function () {
    $policy = new TaskPolicy();
    $task = new Task();
    $task->assigned_to = 22;

    $assignedDeveloper = new User();
    $assignedDeveloper->id = 22;
    $assignedDeveloper->role = UserRole::DEVELOPER;

    $otherDeveloper = new User();
    $otherDeveloper->id = 77;
    $otherDeveloper->role = UserRole::DEVELOPER;

    $manager = new User();
    $manager->id = 22;
    $manager->role = UserRole::MANAGER;

    expect($policy->changeStatus($assignedDeveloper, $task))->toBeTrue()
        ->and($policy->changeStatus($otherDeveloper, $task))->toBeFalse()
        ->and($policy->changeStatus($manager, $task))->toBeFalse();
});

test('task delete is allowed for admin and project owner manager only', function () {
    $policy = new TaskPolicy();

    $project = new Project();
    $project->created_by = 10;

    $task = new Task();
    $task->setRelation('project', $project);

    $ownerManager = new User();
    $ownerManager->id = 10;
    $ownerManager->role = UserRole::MANAGER;

    $otherManager = new User();
    $otherManager->id = 7;
    $otherManager->role = UserRole::MANAGER;

    $admin = new User();
    $admin->id = 99;
    $admin->role = UserRole::ADMIN;

    $developer = new User();
    $developer->id = 10;
    $developer->role = UserRole::DEVELOPER;

    expect($policy->delete($ownerManager, $task))->toBeTrue()
        ->and($policy->delete($otherManager, $task))->toBeFalse()
        ->and($policy->delete($admin, $task))->toBeTrue()
        ->and($policy->delete($developer, $task))->toBeFalse();
});
