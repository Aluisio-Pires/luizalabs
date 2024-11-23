<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionTypeRequest extends FormRequest
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
        $transactionTypeId = $this->route('transaction_type')->id ?? null;

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('transaction_types', 'name')->ignore($transactionTypeId),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
