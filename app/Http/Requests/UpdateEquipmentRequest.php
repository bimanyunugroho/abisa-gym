<?php

namespace App\Http\Requests;

use App\Enums\ConditionEnum;
use App\Models\Equipment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
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
            'category_id' => [$this->isUpdate() ? 'required' : 'sometimes', 'exists:equipment_categories,id'],
            'name' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'max:255', Rule::unique(Equipment::class)->ignore($this->route('equipment')->id)],
            'description' => ['nullable', 'string'],
            'usage_instructions' => ['nullable', 'string'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'purchase_date' => [$this->isUpdate() ? 'required' : 'sometimes', 'date'],
            'last_maintenance_date' => ['nullable', 'date'],
            'condition' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', Rule::in(ConditionEnum::values())],
            'is_active' => [$this->isUpdate() ? 'required' : 'sometimes', 'boolean'],
        ];
    }

    private function isUpdate()
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
