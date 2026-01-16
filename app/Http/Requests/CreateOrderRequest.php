<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deliveryAddress' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'deliveryAddress.max' => 'Delivery address must not exceed 500 characters',
            'phone.max' => 'Phone must not exceed 20 characters',
            'notes.max' => 'Notes must not exceed 1000 characters',
        ];
    }
}

