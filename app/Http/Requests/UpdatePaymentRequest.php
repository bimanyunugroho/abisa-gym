<?php

namespace App\Http\Requests;

use App\Models\GymVisit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentTypeEnum;
use App\Enums\StatusPaymentEnum;

class UpdatePaymentRequest extends FormRequest
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
            'payable_id' => [$this->isUpdate() ? 'required' : 'sometimes', 'exists:gym_visits,id'],
            'payable_type' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', Rule::in([GymVisit::class])],
            'no_payment' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', 'max:255'],
            'amount' => [$this->isUpdate() ? 'required' : 'sometimes', 'numeric', 'min:0'],
            'payment_method' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', Rule::in(PaymentMethodEnum::values())],
            'payment_type' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', Rule::in(PaymentTypeEnum::values())],
            'status' => [$this->isUpdate() ? 'required' : 'sometimes', 'string', Rule::in(StatusPaymentEnum::values())],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function isUpdate()
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
