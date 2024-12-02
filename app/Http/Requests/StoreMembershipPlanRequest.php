<?php

namespace App\Http\Requests;

use App\Enums\DurationTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMembershipPlanRequest extends FormRequest
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
            'member_level_id' => ['required', 'exists:member_levels,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['nullable', 'integer', 'min:0'],
            'duration_type' => ['required', Rule::in(DurationTypeEnum::values())],
            'visit_limit' => ['nullable', 'integer', 'min:0'],
            'access_all_branches' => ['required', 'boolean'],
            'available_times' => ['required', 'array', 'min:1'],
            'available_times.*.start' => ['required', 'date_format:H:i'],
            'available_times.*.end' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $start = $this->input("available_times.{$index}.start");
                    
                    if ($start && $value) {
                        $startTime = strtotime($start);
                        $endTime = strtotime($value);
                        
                        if ($endTime <= $startTime) {
                            $fail('Waktu selesai harus lebih besar dari waktu mulai.');
                        }
                    }
                },
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'available_times.required' => 'Waktu tersedia wajib diisi',
            'available_times.array' => 'Format waktu tersedia tidak valid',
            'available_times.min' => 'Minimal harus ada satu waktu tersedia',
            'available_times.*.start.required' => 'Waktu mulai wajib diisi',
            'available_times.*.start.date_format' => 'Format waktu mulai tidak valid',
            'available_times.*.end.required' => 'Waktu selesai wajib diisi',
            'available_times.*.end.date_format' => 'Format waktu selesai tidak valid',
        ];
    }
}
