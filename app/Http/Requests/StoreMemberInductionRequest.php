<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberInductionRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'trainer_id' => ['required', 'exists:users,id'],
            'equipment_category_id' => ['required', 'exists:equipment_categories,id'],
            'induction_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'is_completed' => ['required', 'boolean'],
        ];
    }
}
