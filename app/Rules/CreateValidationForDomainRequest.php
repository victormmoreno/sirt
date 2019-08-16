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

        $servidor = ServidorVideo::pluck('dominio')->push("youtu.be")->toArray();

        // dd($servidor);

        if($this->checkServer(["youtube.com","youtu.be"], $value ) ) {
            $pattern = '#^(?:https?://)?'; # Optional URL scheme. Either http or https.
            $pattern .= '(?:www\.)?'; #  Optional www subdomain.
            $pattern .= '(?:'; #  Group host alternatives:
            $pattern .= 'youtu\.be/'; #    Either youtu.be,
            $pattern .= '|youtube\.com'; #    or youtube.com
            $pattern .= '(?:'; #    Group path alternatives:
            $pattern .= '/embed/'; #      Either /embed/,
            $pattern .= '|/v/'; #      or /v/,
            $pattern .= '|/watch\?v='; #      or /watch?v=,
            $pattern .= '|/watch\?.+&v='; #      or /watch?other_param&v=
            $pattern .= '|/watch\?.+&v='; #      or /watch?other_param&v=
            $pattern .= ')'; #    End path alternatives.
            $pattern .= ')'; #  End host alternatives.
            $pattern .= '([\w-]{11})'; # 11 characters (Length of Youtube video ids).
            $pattern .= '(?:.+)?$#x'; # Optional other ending URL parameters.
            preg_match($pattern, $value, $matches);
            return (isset($matches[1])) ? $matches[1] : false;
        }
        else if($this->checkServer($servidor, $value ) ) {
            //is Any Domain
            return true;
        }else {
            //unknow domain
            return false;
        }

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

    private function checkServer($domains=[], $url) {
        foreach ( $domains as $domain ) {
            if ( strpos($url, $domain ) > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
}
