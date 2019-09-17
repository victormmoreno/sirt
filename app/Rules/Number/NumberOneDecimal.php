<?php

namespace App\Rules\Number;

use Illuminate\Contracts\Validation\Rule;

class NumberOneDecimal implements Rule
{
    

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $number = preg_match('/^(?:d*.d{1,2}|d+)$', $value);

        return dd($number);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
