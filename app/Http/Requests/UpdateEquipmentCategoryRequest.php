<?php

namespace App\Http\Requests;

use App\Enums\DifficultyEnum;
use App\Models\EquipmentCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentCategoryRequest extends FormRequest
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
            'name' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'max:255', Rule::unique(EquipmentCategory::class)->ignore($this->route('equipment_category')->id)],
            'difficulty_level' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', Rule::in(DifficultyEnum::values())],
            'needs_supervision' => [$this->isUpdate() ? 'required' : 'sometimes', 'boolean'],
        ];
    }

    private function isUpdate()
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
