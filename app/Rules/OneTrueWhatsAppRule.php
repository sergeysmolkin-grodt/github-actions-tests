<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OneTrueWhatsAppRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $whatsAppFields = [
            'has_whatsapp_30_minutes',
            'has_whatsapp_5_minutes',
            'has_whatsapp_3_hours',
        ];

        foreach ($whatsAppFields as $field) {
            if ($field !== $attribute
                && request()->input($field)
                && $value
            ) {
                $fail("The $field must be false.");
            }
        }
    }
}
