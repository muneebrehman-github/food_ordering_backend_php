<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'foodItemId' => ['required', 'integer', 'exists:food_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'foodItemId.required' => 'Food item ID is required',
            'foodItemId.exists' => 'Food item not found',
            'quantity.required' => 'Quantity is required',
            'quantity.min' => 'Quantity must be at least 1',
        ];
    }
}

