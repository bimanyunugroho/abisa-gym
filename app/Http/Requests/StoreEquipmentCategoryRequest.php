<?php

namespace App\Http\Requests;

use App\Enums\DifficultyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:equipment_categories'],
            'difficulty_level' => ['required', 'string', Rule::in(DifficultyEnum::values())],
            'needs_supervision' => ['required', 'boolean'],
        ];
    }
}
