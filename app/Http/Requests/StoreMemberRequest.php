<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Generate default password based on name
        $this->merge([
            'password' => strtolower(str_replace(' ', '_', $this->input('name')) . '_123456')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::in(RoleEnum::MEMBER->value, RoleEnum::TRAINER->value, RoleEnum::ADMIN->value)],
            'phone_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'string', Rule::in(GenderEnum::values())],
            'health_conditions' => ['nullable', 'string'],
            'emergency_contact' => ['nullable', 'string'],
        ];
    }
}