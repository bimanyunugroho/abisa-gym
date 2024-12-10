<?php

namespace App\Http\Requests;

use App\Enums\ConditionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
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
            'category_id' => ['required', 'exists:equipment_categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:equipments'],
            'description' => ['nullable', 'string'],
            'usage_instructions' => ['nullable', 'string'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'purchase_date' => ['required', 'date'],
            'last_maintenance_date' => ['nullable', 'date'],
            'condition' => ['required', 'string', Rule::in(ConditionEnum::values())],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
