<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class PhoneRussiaRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $failText = 'Пожалуйста, используйсте существующий российский номер телефона.';
        try {
            $phoneNumber = $phoneUtil->parse($value, 'RU');
            if (!$phoneUtil->isValidNumberForRegion($phoneNumber, 'RU')) {
                $fail($failText);
            }
        } catch (NumberParseException $e) {
            $fail($failText);
        }
    }
}
