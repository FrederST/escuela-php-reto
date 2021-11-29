<?php

namespace App\Http\Requests\Api\Currency;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from' => ['required', 'min:3', 'max:3'],
            'to' => ['required', 'min:3'],
            'value' => ['required', 'numeric', 'min:1'],
        ];
    }
}
