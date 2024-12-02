<?php

namespace App\Http\Requests;

use App\Models\Account;
use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

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
     * @return array<string, ValidationRule|list<Closure|string>|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'string', 'max:255', 'exists:transaction_types,slug'],
            'amount' => ['required', 'decimal:2', 'min:0'],
            'account_number' => [
                'required',
                'integer',
                'exists:accounts,number',
                function ($attribute, $value, $fail): void {
                    $userId = Auth::id();
                    $account = Account::where('number', $value)
                        ->where('user_id', $userId)
                        ->first();

                    if (! $account) {
                        $fail('A conta selecionada não pertence ao usuário autenticado.');
                    }
                },
            ],
            'payee_number' => [
                'nullable',
                'integer',
                'required_if:type,transferencia',
                'exists:accounts,number',
                'different:account_number',
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'description' => 'Descrição',
            'type' => 'Tipo de Transação',
            'amount' => 'Valor',
            'account_number' => 'Conta de Origem',
            'payee_number' => 'Conta de Destino',
        ];
    }

    /**
     * @throws Exception
     */
    protected function prepareForValidation(): void
    {
        $this->ensureIdempotency();

        $this->merge([
            'account_number' => (string) $this->input('account_number'),
            'payee_number' => (string) $this->input('payee_number'),
        ]);
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
