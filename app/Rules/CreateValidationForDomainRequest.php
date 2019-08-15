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
        $domain = explode('.', $url['host']);
        dd($domain);



        // $sear = array_search(ServidorVideo::pluck('nombre')->toArray(), $domain);

        // $resultado = array_diff(ServidorVideo::pluck('nombre')->toArray(), $domain);
        // dd($domain[1]);

        // if ($resultado != $domain[1]) {
        //     dd('es direferente');
        // }
        // dd('es igual');
        
      

        // $servidor = collect(ServidorVideo::pluck('nombre'))->contains($domain[1]);

        // if (!empty($servidor) || $url['host'] == 'youtu.be' ) {
        //     return true;
        // }
        // return false;

        
        // $servidor = ServidorVideo::select('dominio')->where('dominio', $url['host'])->first();


        // if ($url['host'] == ) {
        //     # code...
        // }

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

        // $url = @parse_url($value);

        // $servidor = ServidorVideo::select('dominio')->where('dominio', $url['host'])->first();

        // dd($servidor);



        // if (!empty($servidor) && $servidor != null || $url['host'] == 'youtu.be') {
        //     return true;
        // }
        // return false;

        // $regex = preg_match("/http:\/\/(?:www.)?(?:(vimeo).com\/(.*)|(youtube).com\/watch\?v=(.*?)&)/", $value);

        // return $regex;
        //

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
