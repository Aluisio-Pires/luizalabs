<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexTrailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'action' => ['nullable', 'string', 'in:created,updated,deleted'],
            'relation_name' => ['sometimes', 'required_with:relation_name', 'string', 'in:accounts,transactions'],
            'relation_id' => ['sometimes', 'integer', "exists:{$this->get('relation_name')},id"],
        ];
    }
}
