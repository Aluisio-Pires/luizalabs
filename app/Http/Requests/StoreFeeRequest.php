<?php

namespace App\Http\Requests;

use App\Models\TransactionType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFeeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'string', 'in:fixed,percentage'],
            'value' => ['required', 'decimal:2', 'min:0'],
            'transaction_type_name' => ['required', 'exists:transaction_types,slug'],
            'transaction_type_id' => ['sometimes'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nome',
            'description' => 'Descrição',
            'type' => 'Tipo de Taxação',
            'value' => 'Valor',
            'transaction_type_name' => 'Tipo de Transação',
        ];
    }

    public function prepareForValidation(): void
    {
        if ($this->has('transaction_type_name')) {
            $transactionType = TransactionType::where('slug', $this->transaction_type_name)->first();

            $this->merge([
                'transaction_type_id' => $transactionType?->getKey(),
            ]);
        }
    }
}
