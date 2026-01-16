<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\AuthResponse;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->authService->register($request->validated());
        return response()->json(
            ApiResponse::success(new AuthResponse($data), 'User registered successfully'),
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());
        return response()->json(
            ApiResponse::success(new AuthResponse($data), 'Login successful')
        );
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(
            ApiResponse::success(null, 'Logout successful')
        );
    }

    public function getProfile(): JsonResponse
    {
        $user = $this->authService->getCurrentUser();
        return response()->json(
            ApiResponse::success(new UserResource($user))
        );
    }
}

