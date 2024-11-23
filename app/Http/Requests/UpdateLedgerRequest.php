<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLedgerRequest extends FormRequest
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
        $ledgerId = $this->route('ledger')->id ?? null;

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('ledgers', 'name')->ignore($ledgerId),
            ],
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ];
    }
}
