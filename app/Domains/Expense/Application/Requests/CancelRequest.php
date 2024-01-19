<?php

namespace App\Domains\Expense\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelRequest extends FormRequest
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
            'id' => 'required|integer|exists:stored_events,id',
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
        ];
    }

    /**
     * @param $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['id'] = $this->route('id');
        return $data;
    }
}
