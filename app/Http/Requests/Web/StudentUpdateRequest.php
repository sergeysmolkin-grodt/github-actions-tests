<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'mobile_no' => 'required|string|max:20',
            'is_active' => 'nullable|bool',
            'has_gift_sessions' => 'nullable|bool',
            'has_email_notification' => 'nullable|bool',
            'has_free_sessions_for_company' => 'nullable|bool',
            'has_recurring_gift_sessions' => 'nullable|bool',
            'has_free_unlimited_sessions' => 'nullable|bool',
            'has_free_recurring_sessions_for_company' => 'nullable|bool',
            'count_trial_sessions' => 'nullable|integer',
            'count_gift_sessions' => 'nullable|integer',
            'count_recurring_gift_sessions' => 'nullable|integer',
            'count_company_sessions' => 'nullable|integer',
            'company_id' => 'nullable|integer',
            'plan_id' => 'nullable|integer',
        ];
    }
}
