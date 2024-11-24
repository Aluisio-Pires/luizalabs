<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubledgerRequest extends FormRequest
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
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'value' => ['sometimes', 'decimal:2', 'min:0'],
            'ledger_id' => ['sometimes', 'exists:ledgers,id'],
            'transaction_id' => ['sometimes', 'exists:transactions,id'],
        ];
    }
}
