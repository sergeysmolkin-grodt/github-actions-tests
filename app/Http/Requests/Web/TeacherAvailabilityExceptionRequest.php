<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class TeacherAvailabilityExceptionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'date' => 'required|string',
            'teacher_id' => 'required|integer',
            'from_time' => 'nullable|string',
            'to_time' => 'nullable|string',
            'break_from_time' => 'nullable|string',
            'break_to_time' => 'nullable|string',
        ];
    }
}
