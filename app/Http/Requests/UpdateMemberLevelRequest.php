<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberLevelRequest extends FormRequest
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
            'name' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'can_train_without_trainer' => [$this->isUpdate() ? 'required' : 'sometimes', 'boolean'],
            'needs_orientation' => [$this->isUpdate() ? 'required' : 'sometimes', 'boolean'],
            'has_trainer_access' => [$this->isUpdate() ? 'required' : 'sometimes', 'boolean'],
            'max_guests' => [$this->isUpdate() ? 'required' : 'sometimes', 'integer', 'min:0'],
            'guest_fee' => [$this->isUpdate() ? 'required' : 'sometimes', 'numeric', 'min:0'],
        ];
    }

    private function isUpdate()
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
