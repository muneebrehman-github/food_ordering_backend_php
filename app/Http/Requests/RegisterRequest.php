<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullName' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^[+]?[0-9]{10,15}$/', 'unique:users,phone'],
            'email' => ['nullable', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'fullName.required' => 'Full name is required',
            'fullName.min' => 'Full name must be between 2 and 100 characters',
            'fullName.max' => 'Full name must be between 2 and 100 characters',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Invalid phone number format',
            'phone.unique' => 'Phone number is already registered',
            'email.email' => 'Invalid email format',
            'email.unique' => 'Email is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
        ];
    }
}

