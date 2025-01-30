<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'basket' => 'required|array',
            'basket.*.name' => 'required|string|max:255',
            'basket.*.type' => 'required|in:unit,subscription',
            'basket.*.price' => 'required|numeric',
        ];
    }
}
