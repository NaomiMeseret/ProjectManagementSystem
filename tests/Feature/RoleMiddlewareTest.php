<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Route;

test('role middleware allows listed role', function () {
    Route::middleware(['web', 'auth', 'role:manager'])->get('/middleware-allowed', function () {
        return 'allowed';
    });

    $manager = User::factory()->create([
        'role' => UserRole::MANAGER->value,
    ]);

    $this->actingAs($manager)
        ->get('/middleware-allowed')
        ->assertOk()
        ->assertSee('allowed');
});

test('role middleware blocks unlisted role', function () {
    Route::middleware(['web', 'auth', 'role:manager'])->get('/middleware-blocked', function () {
        return 'blocked';
    });

    $developer = User::factory()->create([
        'role' => UserRole::DEVELOPER->value,
    ]);

    $this->actingAs($developer)
        ->get('/middleware-blocked')
        ->assertForbidden();
});
