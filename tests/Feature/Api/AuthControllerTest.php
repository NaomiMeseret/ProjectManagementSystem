<?php

use App\Enums\UserRole;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

test('user can register through the api and receive a token', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'message',
            'token',
        ])
        ->assertJson([
            'message' => 'Registration successful.',
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'role' => UserRole::DEVELOPER->value,
    ]);

    $token = $response->json('token');
    $storedToken = PersonalAccessToken::first();

    expect($storedToken)->not->toBeNull()
        ->and($storedToken->token)->not->toBe($token);
});

test('user can log in through the api and receive a token', function () {
    $user = User::factory()->create([
        'email' => 'manager@example.com',
        'password' => 'password',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'token',
        ])
        ->assertJson([
            'message' => 'Login successful.',
        ]);

    $token = $response->json('token');
    $storedToken = PersonalAccessToken::latest()->first();

    expect($storedToken)->not->toBeNull()
        ->and($storedToken->token)->not->toBe($token);
});

test('api login fails with invalid credentials', function () {
    User::factory()->create([
        'email' => 'manager@example.com',
        'password' => 'password',
    ]);

    $this->postJson('/api/login', [
        'email' => 'manager@example.com',
        'password' => 'wrong-password',
    ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('authenticated api user can log out and delete the current token', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $this->postJson('/api/logout')
        ->assertOk()
        ->assertJson([
            'message' => 'Logout successful.',
        ]);
});
