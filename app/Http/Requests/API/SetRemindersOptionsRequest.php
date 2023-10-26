<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OneTrueWhatsAppRule;

class SetRemindersOptionsRequest extends FormRequest
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
            'has_email_10_minutes_zoom_data' => 'required|bool',
            'has_whatsapp_30_minutes' => ['required', 'bool', new OneTrueWhatsAppRule],
            'has_whatsapp_5_minutes' => ['required', 'bool', new OneTrueWhatsAppRule],
            'has_whatsapp_3_hours' => ['required', 'bool', new OneTrueWhatsAppRule],
            'has_ivr_2_5_minutes' => 'required|bool',
        ];
    }
}
