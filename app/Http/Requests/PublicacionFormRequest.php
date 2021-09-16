<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicacionFormRequest extends FormRequest
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
            'txttitulo' => 'required|min:10|max:50',
            'txtrole_id' => 'required',
            'txtfecha_inicio' => 'required|date_format:"Y-m-d"',
            'txtfecha_fin' => 'required|date_format:"Y-m-d"|after:txtfecha_inicio',
            'txtcontenido' => 'min:10|max:1000',
        ];
    }

    public function messages()
    {
        return $messages = [
            // Mensaje para el input txttitulo
            'txttitulo.required' => 'El Título de la Publicación es obligatoria.',
            'txttitulo.min' => 'El Título de la Publicación debe ser mínimo de 10 carácteres.',
            'txttitulo.max' => 'El Título de la Publicación debe ser máximo de 50 carácteres.',
            // Mensajes para el input txtrole_id
            'txtrole_id.required' => 'El Rol al que se le va a mostrar la publicación debe ser obligatorio.',
            // Mensajes para el input txtfecha_inicio
            'txtfecha_inicio.required' => 'La Fecha de Inicio es obligatoria.',
            'txtfecha_inicio.date_format' => 'El formato de la Fecha de Inicio es incorrecto.',
            // Mensajes para el input txtfecha_inicio
            'txtfecha_fin.required' => 'La Fecha de Inicio es obligatoria.',
            'txtfecha_fin.date_format' => 'El formato de la Fecha de Inicio es incorrecto.',
            'txtfecha_fin.after' => 'La fecha de fin debe ser una fecha posterior a la fecha de inicio.',
            // Mensajes para el input txtcontenido
            'txtcontenido.required' => 'El contenido de la publicación es obligatorio.',
            'txtcontenido.min' => 'El contenido de la publicación debe ser mínimo 10 carácteres.',
            'txtcontenido.max' => 'El contenido de la publicación debe ser máximo 1000 carácteres.',
        ];
    }
}
