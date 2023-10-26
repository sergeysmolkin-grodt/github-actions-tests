<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        //TODO extend password validation
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'mobile' => 'required|string',
            'ageGroup' => 'required|string',
            'birthDate' => 'required_if:role,teacher|string',
            'gender' => 'required_if:role,teacher|string',
            'deviceToken' => 'nullable|string',
            'deviceType' => 'nullable|string',
            'deviceId' => 'nullable|string',
            'profileImage' => 'nullable|file|mimes:'. implode(',', config('app.file_extensions')),
            'loginType' => 'required|string',
            'countryCode' => 'required|string',
            'language' => 'nullable|string',
            'OSVersion' => 'nullable|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'referralId' => 'nullable|string',
            'socialLoginId' => 'required_unless:loginType,NORMAL|string',
            'role' => 'required|string|in:student,teacher'
        ];
    }
}
