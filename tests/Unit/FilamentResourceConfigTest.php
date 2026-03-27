<?php

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Tasks\TaskResource;
use App\Filament\Resources\Users\UserResource;

test('filament resources use real columns for record title attribute', function () {
    expect(resourceTitleAttribute(ProjectResource::class))->toBe('name')
        ->and(resourceTitleAttribute(TaskResource::class))->toBe('title')
        ->and(resourceTitleAttribute(UserResource::class))->toBe('name');
});

function resourceTitleAttribute(string $resourceClass): ?string
{
    $reflection = new ReflectionClass($resourceClass);
    $property = $reflection->getProperty('recordTitleAttribute');
    $property->setAccessible(true);

    return $property->getValue();
}
