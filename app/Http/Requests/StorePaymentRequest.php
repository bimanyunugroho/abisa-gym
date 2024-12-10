<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentTypeEnum;
use App\Enums\StatusPaymentEnum;
use App\Models\GymVisit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
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
            'payable_id' => ['required', 'exists:gym_visits,id'],
            'payable_type' => ['required', 'string', Rule::in([GymVisit::class])],
            'no_payment' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string', Rule::in(PaymentMethodEnum::values())],
            'payment_type' => ['required', 'string', Rule::in(PaymentTypeEnum::values())],
            'status' => ['required', 'string', Rule::in(StatusPaymentEnum::values())],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }
}
