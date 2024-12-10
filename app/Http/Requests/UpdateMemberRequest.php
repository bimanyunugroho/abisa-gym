<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
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
            'name' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'max:255'],
            'email' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->route('member')->id)],
            'password' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'min:8'],
            'phone_number' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'max:255'],
            'address' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'max:255'],
            'birth_date' => [$this->isUpdate() ? 'required' : 'sometimes', 'date'],
            'gender' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', Rule::in(GenderEnum::values())],
            'health_conditions' => ['nullable', 'string'],
            'emergency_contact' => ['nullable', 'string'],
        ];
    }

    private function isUpdate()
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
