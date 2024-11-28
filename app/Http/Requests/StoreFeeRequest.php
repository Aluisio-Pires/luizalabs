<?php

namespace App\Http\Requests;

use App\Models\TransactionType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

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
     * @return array<string, ValidationRule|string[]|string>
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

    /**
     * @return string[]
     */
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
        $this->ensureIdempotency();

        if ($this->has('transaction_type_name')) {
            $transactionType = TransactionType::where('slug', $this->transaction_type_name)->first();

            $this->merge([
                'transaction_type_id' => $transactionType?->getKey(),
            ]);
        }
    }

    protected function ensureIdempotency(): void
    {
        $data = json_encode($this->all()) ?: 'Falha ao recuperar os dados';
        $dataHash = hash('sha256', $data);
        if (Cache::has($dataHash)) {
            abort(Response::HTTP_CONFLICT, 'Transação duplicada');
        }
        Cache::put($dataHash, true, now()->addSeconds(15));
    }
}
