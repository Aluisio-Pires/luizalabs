<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'balance' => ['sometimes', 'decimal:2', 'min:0'],
            'credit_limit' => ['sometimes', 'decimal:2', 'min:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'balance' => 'Saldo',
            'credit_limit' => 'Limite de Crédito',
        ];
    }
}
