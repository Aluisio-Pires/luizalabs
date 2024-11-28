<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

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
     * @return array<string, ValidationRule|string[]|string>
     */
    public function rules(): array
    {
        return [
            'balance' => ['sometimes', 'decimal:2', 'min:0'],
            'credit_limit' => ['sometimes', 'decimal:2', 'min:0'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'balance' => 'Saldo',
            'credit_limit' => 'Limite de Crédito',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->ensureIdempotency();
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
