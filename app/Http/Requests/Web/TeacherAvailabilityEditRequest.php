<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class TeacherAvailabilityEditRequest extends FormRequest
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
            'availabilities' => 'required|array',
            'availabilities.*.day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'availabilities.*.id' => 'nullable|integer',
            'availabilities.*.from_time' => 'nullable',
            'availabilities.*.to_time' => 'nullable',
            'availabilities.*.break_from_time' => 'nullable',
            'availabilities.*.break_to_time' => 'nullable',
            'availabilities.*.is_available' => 'nullable|boolean',
            'availabilities.*.force_change' => 'required',
        ];
    }
}
