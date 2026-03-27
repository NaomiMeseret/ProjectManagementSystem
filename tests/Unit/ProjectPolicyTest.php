<?php

use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Policies\ProjectPolicy;

test('project view any is allowed for admin manager and developer', function () {
    $policy = new ProjectPolicy();

    $admin = new User();
    $admin->role = UserRole::ADMIN;

    $manager = new User();
    $manager->role = UserRole::MANAGER;

    $developer = new User();
    $developer->role = UserRole::DEVELOPER;

    expect($policy->viewAny($admin))->toBeTrue()
        ->and($policy->viewAny($manager))->toBeTrue()
        ->and($policy->viewAny($developer))->toBeTrue();
});

test('project view is allowed for admin owner manager and assigned developer only', function () {
    $policy = new ProjectPolicy();

    $project = new Project();
    $project->created_by = 10;
    $project->setRelation('tasks', collect([
        tap(new Task(), function (Task $task) {
            $task->assigned_to = 55;
        }),
    ]));

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
    $assignedDeveloper->id = 55;
    $assignedDeveloper->role = UserRole::DEVELOPER;

    $otherDeveloper = new User();
    $otherDeveloper->id = 22;
    $otherDeveloper->role = UserRole::DEVELOPER;

    expect($policy->view($ownerManager, $project))->toBeTrue()
        ->and($policy->view($otherManager, $project))->toBeFalse()
        ->and($policy->view($admin, $project))->toBeTrue()
        ->and($policy->view($assignedDeveloper, $project))->toBeTrue()
        ->and($policy->view($otherDeveloper, $project))->toBeFalse();
});

test('project update is allowed for admin and owner manager only', function () {
    $policy = new ProjectPolicy();

    $project = new Project();
    $project->created_by = 10;

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

    expect($policy->update($ownerManager, $project))->toBeTrue()
        ->and($policy->update($otherManager, $project))->toBeFalse()
        ->and($policy->update($admin, $project))->toBeTrue()
        ->and($policy->update($developer, $project))->toBeFalse();
});

test('project delete is allowed for admin and owner manager only', function () {
    $policy = new ProjectPolicy();

    $project = new Project();
    $project->created_by = 10;

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

    expect($policy->delete($ownerManager, $project))->toBeTrue()
        ->and($policy->delete($otherManager, $project))->toBeFalse()
        ->and($policy->delete($admin, $project))->toBeTrue()
        ->and($policy->delete($developer, $project))->toBeFalse();
});
