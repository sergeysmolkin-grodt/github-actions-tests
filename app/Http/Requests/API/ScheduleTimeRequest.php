<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleTimeRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;


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
    public function rules(): array
    {
        return [
            'autoScheduleDate' => 'required|date',
            'timeDetails' => 'required|array',
            'timeDetails.*.teacherId' => 'required|integer',
            'timeDetails.*.day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'timeDetails.*.time' => 'required|string'
        ];
    }
}
