<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberLevelRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'can_train_without_trainer' => ['required', 'boolean'],
            'needs_orientation' => ['required', 'boolean'],
            'has_trainer_access' => ['required', 'boolean'],
            'max_guests' => ['required', 'integer', 'min:0'],
            'guest_fee' => ['required', 'numeric', 'min:0'],
        ];
    }
}
