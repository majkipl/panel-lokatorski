<?php

namespace App\Domains\Payment\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'integer' => 'The :attribute field must be an integer.',
            'exists' => 'The selected :attribute is invalid.',
            'numeric' => 'The :attribute field must be a number.'
        ];
    }
}
