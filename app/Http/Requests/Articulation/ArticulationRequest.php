<?php

namespace App\Http\Requests\Articulation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticulationRequest extends FormRequest
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
            'articulation_type'         => 'required',
            'articulation_subtype'      => 'required',
            'start_date'                => 'required',
            'name'                      => 'required|min:1|max:600',
            'description'               => 'required|min:1|max:3000',
            'scope'                     => 'required',
            'talents'                   => 'required',
            'name_entity'               => 'required|min:1|max:191',
            'name_contact'              => 'required|min:1|max:191',
            'email_entity'              => 'required|email|max:191',
            'summon_name'               => 'max:100',
            'expected_date'             => 'required',
            'objective'                 => 'required|min:1|max:3000',
        ];
    }

    public function messages()
    {
        return [
            'articulation_type.required'        => 'El campo tipo articulación es obligatorio.',
            'articulation_subtype.required'     => 'El campo tipo subarticulación es obligatorio.',
            'start_date.required'               => 'El campo fecha inicio es obligatorio.',
            'name.required'                     => 'El campo nombre es obligatorio.',
            'name.min'                          => 'El campo nombre debe ser de al menos :min caracter.',
            'name.max'                          => 'El campo nombre no debe ser mayor a :max caracter(es)',
            'description.required'              => 'El campo descripción es obligatorio.',
            'description.min'                   => 'El campo descripción debe ser de al menos :min caracter.',
            'description.max'                   => 'El campo descripción no debe ser mayor a :max caracter(es)',
            'scope.required'                    => 'El campo alcance es obligatorio.',
            'email_entity.required'             => 'El campo correo es obligatorio.',
            'email_entity.min'                  => 'El campo correo debe ser de al menos :min caracter.',
            'email_entity.max'                  => 'El campo correo no debe ser mayor a :max caracter(es)',
            'talents.required'                  => 'Debe asociar un talento.',
            'name_entity.required'              => 'El campo nombre entidad es obligatorio.',
            'name_entity.min'                   => 'El campo nombre entidad debe ser de al menos :min caracter.',
            'name_entity.max'                   => 'El campo nombre entidad no debe ser mayor a :max caracter(es)',
            'name_contact.required'             => 'El campo nombre contacto es obligatorio.',
            'name_contact.min'                  => 'El campo nombre contacto debe ser de al menos :min caracter.',
            'name_contact.max'                  => 'El campo nombre contacto no debe ser mayor a :max caracter(es)',
            'summon_name.required'                => 'El campo es obligatorio.',
            'summon_name.min'                     => 'El campo debe ser de al menos :min caracter.',
            'summon_name.max'                     => 'El campo no debe ser mayor a :max caracter(es)',
        ];
    }
}
