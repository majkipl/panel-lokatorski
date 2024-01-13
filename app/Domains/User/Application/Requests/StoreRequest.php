<?php

namespace App\Domains\User\Application\Requests;

use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'firstname' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
            'role' => [
                'required',
                Rule::in(array_map(fn($case) => $case->value, UserRole::cases()))
            ],
            'status' => [
                'required',
                Rule::in(array_map(fn($case) => $case->value, UserStatus::cases()))
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute field must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
            'string' => 'The :attribute field must be an string.',
            'in' => 'The selected :attribute is invalid.',
            'firstname.min' => 'The :attribute field must be at least 3 characters.',
            'lastname.min' => 'The :attribute field must be at least 3 characters.',
            'password.min' => 'The :attribute field must be at least 8 characters.',
        ];
    }
}
