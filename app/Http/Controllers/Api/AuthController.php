<?php

namespace App\Http\Controllers\Api;

use App\DTOS\LoginDTO;
use App\DTOS\UserDTO;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $dto = new LoginDTO(
            email: $request->email,
            password: $request->password,
        );

        $token = $this->authService->login($dto);

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = new UserDTO(
            id: null,
            name: $request->name,
            email: $request->email,
            password: $request->password,
            role: UserRole::DEVELOPER,
        );

        $token = $this->authService->register($dto);

        return response()->json([
            'message' => 'Registration successful.',
            'token' => $token,
        ], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        abort_unless($user !== null, 401);

        $this->authService->logout($user);

        return response()->json([
            'message' => 'Logout successful.',
        ]);
    }
}
