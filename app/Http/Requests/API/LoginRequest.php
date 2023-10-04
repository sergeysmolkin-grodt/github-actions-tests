<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'loginType' => 'required|string',
            'deviceToken' => 'nullable|string',
            'deviceType' => 'nullable|string',
            'OSVersion' => 'nullable|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'deviceId' => 'nullable|integer'
        ];
    }
}
