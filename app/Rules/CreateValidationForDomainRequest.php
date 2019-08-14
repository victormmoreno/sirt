<?php

namespace App\Rules;

use App\Models\ServidorVideo;
use Illuminate\Contracts\Validation\Rule;

class CreateValidationForDomainRequest implements Rule
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

        $url = @parse_url($value);


        $servidor = ServidorVideo::select('dominio')->where('dominio',$url['host'])->first();
     
        if (empty($servidor) && $servidor == null) {
            return false;
        }
        return true;

        
        // $regex = preg_match('(/([a-z0-9+$_%-]\.?)+)*/?', $value);

        // return $regex;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'por favor ingrese un link correcto';
    }
}
