<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
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
            'scheduleId' => 'required',
            'paymentModeId' => 'required',
            'busModeId' => 'required',
            'course' => 'required',
            'traineeId' => 'required',
            'dormId' => 'required',
            'fleetId' => 'required',
            'registrationNumber' => 'required',
        ];
    }
}
