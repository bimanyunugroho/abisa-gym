<?php

namespace App\Http\Requests;

use App\Enums\StatusMemberEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRegistrationRequest extends FormRequest
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
            'membership_plan_id' => [$this->isUpdate() ? 'required' : 'sometimes', 'exists:membership_plans,id'],
            'start_date' => [$this->isUpdate() ? 'required' : 'sometimes', 'date'],
            'end_date' => [$this->isUpdate() ? 'required' : 'sometimes', 'date'],
            'visits_left' => [$this->isUpdate() ? 'required' : 'sometimes', 'integer'],
            'status' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', Rule::in(StatusMemberEnum::values())],
            'orientation_date' => [$this->isUpdate() ? 'required' : 'sometimes', 'date'],
            'orientation_completed' => [$this->isUpdate() ? 'required' : 'sometimes', 'boolean'],
        ];
    }

    private function isUpdate()
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
