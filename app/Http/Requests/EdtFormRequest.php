<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EdtFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
                'txtfecha_inicio' => 'required|date_format:"Y-m-d"',
                'txtnombre' => 'required|max:200',
                'txtareaconocimiento_id' => 'required',
                'txttipo_edt' => 'required',
                'txtobservaciones' => 'max:1000',
                'txtempleados' => 'required|numeric|min:0',
                'txtinstructores' => 'required|numeric|min:0',
                'txtaprendices' => 'required|numeric|min:0',
                'txtpublico' => 'required|numeric|min:0',
                'entidades' => 'required',
                'txtfecha_fin' => Rule::requiredIf(request()->txtestado == 1) . '|date_format:"Y-m-d"|nullable'
            ];
        }

        public function messages()
        {
        return $messages = [
            /**
            * Mensajes para e campo txtfecha_inicio
            */
            'txtfecha_inicio.required' => 'La Fecha de Inicio de la Edt es obligatoria.',
            'txtfecha_inicio.date_format' => 'El formato de la Fecha de Inicio es incorrecto.',
            /**
            * Mensaje para el campo txtnombre
            */
            'txtnombre.required' => 'El nombre de la Edt es obligatorio.',
            'txtnombre.max' => 'El nombre de la Edt debe ser máximo de 200 carácteres.',
            /**
            * Mensajes para el campo txtareaconocimiento_id
            */
            'txtareaconocimiento_id.required' => 'El Área de Conocimiento es obligatoria.',
            /**
            * Mensajes para el campo txttipo_edt
            */
            'txttipo_edt.required' => 'El Tipo de Edt es obligatorio.',
            /**
            * Mensajes para el campo txtobservaciones
            */
            'txtobservaciones.max' => 'Las Observaciones de la Edt deben ser máximo 1000 carácteres.',
            /**
            * Mensajes para el campo txtempleados
            */
            'txtempleados.required' => 'La cantidad de empleados debe ser obligatoria.',
            'txtempleados.numeric' => 'La cantidad de empleados debe ser numérica.',
            'txtempleados.min' => 'La cantidad de empleados debe ser mínimo 0.',
            /**
            * Mensajes para el campo txtinstructores
            */
            'txtinstructores.required' => 'La cantidad de instructores debe ser obligatoria.',
            'txtinstructores.numeric' => 'La cantidad de instructores debe ser numérica.',
            'txtinstructores.min' => 'La cantidad de instructores debe ser mínimo 0.',
            /**
            * Mensajes para el campo txtaprendices
            */
            'txtaprendices.required' => 'La cantidad de aprendices debe ser obligatoria.',
            'txtaprendices.numeric' => 'La cantidad de aprendices debe ser numérica.',
            'txtaprendices.min' => 'La cantidad de aprendices debe ser mínimo 0.',
            /**
            * Mensajes para el campo txtpublico
            */
            'txtpublico.required' => 'La cantidad de público debe ser obligatoria.',
            'txtpublico.numeric' => 'La cantidad de público debe ser numérica.',
            'txtpublico.min' => 'La cantidad de público debe ser mínimo 0.',
            /**
            * Mensajes para el array de entidades
            */
            'entidades.required' => 'Debe registrar al menos una empresa en la Edt.',
            /**
            * Mensaje para el campo txtfecha_fin
            */
            'txtfecha_fin.required' => 'La Fecha de Cierre de la Edt es obligatoria.',
            'txtfecha_fin.date_format' => 'El formato de la Fecha de Cierre es incorrecto'
        ];
    }
}
