<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class TeacherUpdateRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|string|max:20',
            'country_code' => 'required|string|max:4|min:2',
            'introduction_video' => 'nullable',
            'is_teacher_for_children' => 'required|in:0,1',
            'is_teacher_for_beginner' => 'required|in:0,1',
            'is_teacher_for_business' => 'required|in:0,1',
        ];
    }
}
