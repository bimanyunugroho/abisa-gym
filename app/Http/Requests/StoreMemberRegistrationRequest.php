<?php

namespace App\Http\Requests;

use App\Enums\StatusMemberEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemberRegistrationRequest extends FormRequest
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
            'membership_plan_id' => ['required', 'exists:membership_plans,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'visits_left' => ['required', 'integer'],
            'status' => ['required', 'string', Rule::in(StatusMemberEnum::values())],
            'orientation_date' => ['required', 'date'],
            'orientation_completed' => ['required', 'boolean'],
        ];
    }
}
