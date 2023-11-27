<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InArrayValues implements ValidationRule
{
     protected $allowedValues;

    public function __construct($allowedValues)
    {
        $this->allowedValues = $allowedValues;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       
    }
   
    public function passes($attribute, $value)
    {
        return in_array($value, $this->allowedValues);
    }

    public function message()
    {
        return 'The selected value is invalid.';
    }
}
