<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'amount' => ['required', 'integer', 'min:0'],
            'transaction_type_id' => ['required', 'exists:transaction_types,id'],
            'account_id' => ['required', 'exists:accounts,id'],
            'destination_account_id' => [
                'required_if:type,transferencia',
                'exists:accounts,id',
                'different:account_id',
            ],
        ];
    }
}
