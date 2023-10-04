<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        $roles = array_keys(config('permission.user_roles'));
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        return [
            'role' => 'nullable|in:' . implode(',', $roles),
            'day_availability.*' => 'nullable|in:' . implode(',', $days),
            'time_availability' => 'nullable|in:morning,afternoon,evening',
            'gender' => 'nullable|in:male,female',
        ];
    }

    public function messages(): array
    {
        return [
            'role.in' => 'The selected role is invalid. Please choose a valid role.',
            'availability_day.*.in' => 'The selected availability day is invalid. It should be one of: monday, tuesday, wednesday, thursday, friday, saturday, sunday.',
            'gender.in' => 'The selected gender is invalid. It should either be male or female.',
            'time_slot.in' => 'The selected time slot is invalid. It should be either morning, afternoon, or evening.'
        ];
    }
}
