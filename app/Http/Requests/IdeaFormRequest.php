<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdeaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'fecha'             => 'required|date',
            // 'txtnombres'        => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtnombres'        => 'required|min:1|max:45|alpha',
            'txtapellidos'      => 'required|alpha|min:1|max:45',
            'txtcorreo'         => 'required|email|min:1|max:100',
            'txttelefono'       => 'required|numeric|min:6',
            'txtnombreproyecto' => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'pregunta1'         => 'required',
            'pregunta2'         => 'required',
            'pregunta3'         => 'required',
            'txtdescripcion'    => 'required',
            'txtobjetivo'       => 'required',
            'txtalcance'        => 'required',
            'txtnodo'           => 'required',
        ];
    }

    public function messages()
    {
        return $messages = [
            'fecha.required'     => 'La :attribute es obligatorio.',
            'abbreviaton.max'    => 'La :attribute debe ser máximo 45 caracteres',
            'abbreviaton.min'    => 'La :attribute debe ser minimo 0 caracteres',
            'abbreviaton.unique' => 'La :attribute ingresado ya está en uso',
            'abbreviaton.regex'  => 'La formato del campo :attribute es incorrecto',
            'name.required'      => 'El :attribute es obligatorio.',
            'name.max'           => 'El :attribute debe ser máximo 45 caracteres',
            'name.min'           => 'El :attribute debe ser minimo 0 caracteres',
            'name.unique'        => 'El :attribute ingresado ya está en uso',
            'txtnombres.alpha'        => 'El campo :attribute sólo debe contener letras',
            'txtnombreproyecto.regex'         => 'El formato del campo :attribute es incorrecto',
            'description.min'    => 'El :attribute debe ser minimo 0 caracteres',
            'description.max'    => 'El :attribute debe ser máximo 255 caracteres',
            'state.required'     => 'El :attribute es obligatorio.',
        ];
    }

    public function attributes()
    {
        return [
            'txtnombres'   => 'Nombres',
            'txtapellidos' => 'Apellidos',
            'txtcorreo'    => 'Correo Electrónico',
            'txttelefono'  => 'Telefono',
            'txttelefono'  => 'Telefono',
            'txttelefono'  => 'Telefono',
            'txtnombreproyecto'  => 'Nombre de proyecto',
            'txtnodo'  => 'Nodo',
            'txtdescripcion'  => 'Descripcion',
            'txtobjetivo'  => 'Objetivo',
            'txtalcance'  => 'Alcance',
        ];
    }
}
