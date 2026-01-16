<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Exceptions\BadRequestException;
use App\Exceptions\ResourceNotFoundException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): array
    {
        if (User::where('phone', $data['phone'])->exists()) {
            throw new BadRequestException('Phone number is already registered');
        }

        if (!empty($data['email']) && User::where('email', $data['email'])->exists()) {
            throw new BadRequestException('Email is already registered');
        }

        $user = User::create([
            'full_name' => $data['fullName'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'password' => Hash::make($data['password']),
            'active' => true,
        ]);

        $customerRole = Role::where('name', Role::ROLE_CUSTOMER)->first();
        if (!$customerRole) {
            throw new ResourceNotFoundException('Role not found');
        }

        $user->roles()->attach($customerRole->id);

        $token = JWTAuth::fromUser($user);
        $roles = $user->roles()->pluck('name')->toArray();

        return [
            'token' => $token,
            'type' => 'Bearer',
            'id' => $user->id,
            'fullName' => $user->full_name,
            'phone' => $user->phone,
            'email' => $user->email,
            'roles' => $roles,
        ];
    }

    public function login(array $data): array
    {
        $credentials = [
            'phone' => $data['phone'],
            'password' => $data['password'],
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            throw new \Illuminate\Auth\AuthenticationException('Invalid phone number or password');
        }

        $user = User::where('phone', $data['phone'])->first();
        if (!$user) {
            throw new ResourceNotFoundException('User not found');
        }

        $roles = $user->roles()->pluck('name')->toArray();

        return [
            'token' => $token,
            'type' => 'Bearer',
            'id' => $user->id,
            'fullName' => $user->full_name,
            'phone' => $user->phone,
            'email' => $user->email,
            'roles' => $roles,
        ];
    }

    public function getCurrentUser(): User
    {
        $user = auth()->user();
        if (!$user) {
            throw new ResourceNotFoundException('User not found');
        }
        return $user;
    }
}

