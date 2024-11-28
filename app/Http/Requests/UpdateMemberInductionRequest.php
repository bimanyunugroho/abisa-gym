<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberInductionRequest extends FormRequest
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
            'user_id' => [$this->isUpdate() ? 'required' : 'sometimes', 'exists:users,id'],
            'trainer_id' => [$this->isUpdate() ? 'required' : 'sometimes', 'exists:users,id'],
            'equipment_category_id' => [$this->isUpdate() ? 'required' : 'sometimes', 'exists:equipment_categories,id'],
            'induction_date' => [$this->isUpdate() ? 'required' : 'sometimes', 'date'],
            'notes' => ['nullable', 'string'],
            'is_completed' => [$this->isUpdate() ? 'required' : 'sometimes', 'boolean'],
        ];
    }

    private function isUpdate()
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
