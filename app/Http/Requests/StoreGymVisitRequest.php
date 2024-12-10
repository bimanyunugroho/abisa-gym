<?php

namespace App\Http\Requests;

use App\Enums\VisitTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGymVisitRequest extends FormRequest
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
            'member_registration_id' => ['nullable', 'exists:member_registrations,id'],
            'guest_of' => ['nullable', 'exists:users,id'],
            'check_in_time' => ['required', 'date'],
            'check_out_time' => ['nullable', 'date'],
            'visit_type' => ['required', 'string', Rule::in(VisitTypeEnum::values())],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
