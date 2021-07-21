<?php

namespace App\Http\Requests\ArticulacionPbt;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ArticulacionPbt;
use Illuminate\Validation\Rule;


class ArticulacionFaseInicioFormRequest extends FormRequest
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
            'txttipovinculacion' => 'required',
            'txtpbt' => Rule::requiredIf(request()->txttipovinculacion == ArticulacionPbt::IsPbt()) . '|nullable',
            'txtsede' => Rule::requiredIf(request()->txttipovinculacion == ArticulacionPbt::IsSenaInnova() || request()->txttipovinculacion == ArticulacionPbt::IsColinnova()) . '|nullable',
            'talentos' => 'required',
            'txttalento_interlocutor'=>'required',
            'txtnombre_articulacion' => 'required|min:2|max:191',
            'txt_tipo_articulacion' =>'required',
            'txt_alcance_articulacion' =>'required',
            'txtname_entidad' => 'required|min:2|max:191',
            'txtname_contact' => 'required|min:2|max:191',
            'txtemail'    => 'required|email|min:1|max:100',
            'txtnombre_convocatoria'    => 'nullable|min:1|max:191',
            'txtfecha_esperada' => 'required|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
            'txtfecha_inicio' => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtobjetivo' => 'required|min:2|max:10000',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txttipovinculacion.required' => 'El tipo de vinculación es obligatorio.',
            'txtpbt.required' => 'El proyecto es obligatorio.',
            'txtsede.required' => 'La sede de la empresa es obligatoria.',
            'txt_tipo_articulacion.required' => 'El tipo de articulación es obligatoria.',
            'txt_alcance_articulacion.required' => 'El tipo de articulación es obligatoria.',
            'txttalento_interlocutor.required'=>'Debe haber un interlocutor',


            'talentos.required' => 'Debe asociar por lo menos un talento a la articulación.',

            'txtnombre_articulacion.required' => 'El nombre de la articulación es obligatoria.',
            'txtnombre_articulacion.max' => 'El nombre de la articulación debe ser máximo de 191 carácteres.',
            'txtnombre_articulacion.min' => 'El nombre de la articulación debe ser minimo  de 2 carácteres.',

            'txtname_contact.required' => 'El Nombre de contacto es obligatoria.',
            'txtname_contact.max' => 'El Nombre de contacto debe ser máximo de 191 carácteres.',
            'txtname_contact.min' => 'El Nombre de contacto debe ser minimo  de 2 carácteres.',

            'txtname_entidad.required' => 'El nombre de la entidad es obligatoria.',
            'txtname_entidad.max' => 'El nombre de la entidad debe ser máximo de 191 carácteres.',
            'txtname_entidad.min' => 'El nombre de la entidad debe ser minimo  de 2 carácteres.',

            'txtemail.required' => 'El correo electrónico es obligatorio.',
            'txtemail.min'      => 'El correo electrónico debe ser minimo 1 caracter',
            'txtemail.max'       => 'El correo electrónico debe ser máximo 100 caracteres',

            'txtnombre_convocatoria.max' => 'El nombre de convocatoria debe ser máximo de 191 carácteres.',
            'txtnombre_convocatoria.min' => 'El nombre de convocatoria debe ser minimo  de 2 carácteres.',

            'txtfecha_esperada.required'        => 'La fecha esperada es obligatoria.',
            'txtfecha_esperada.date'            => 'La fecha esperada no es una fecha válida.',
            'txtfecha_esperada.after_or_equal' => 'La fecha esperada debe ser una fecha posterior o igual a la actual',

            'txtfecha_inicio.required'        => 'La fecha de inicio es obligatoria.',
            'txtfecha_inicio.date'            => 'La fecha de inicio no es una fecha válida.',
            'txtfecha_inicio.before_or_equal' => 'La fecha de inicio debe ser una fecha anterior o igual a la actual',

            'txtobjetivo.required' => 'El objetivo es obligatorio.',
            'txtobjetivo.max' => 'El objetivo debe ser máximo de 191 carácteres.',
            'txtobjetivo.min' => 'El objetivo debe ser minimo  de 2 carácteres.',

        ];
    }
}
