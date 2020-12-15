<?php

namespace App\Http\Requests\UsersRequests;

use App\Models\{TipoTalento};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ConfirmUserRequest extends FormRequest
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
            
            'txttipocontratista'        => Rule::requiredIf(request()->txttipousuario == "contratista") . '|nullable|'  .  Rule::in(['contratista', 'planta']),
            'txttipotalento'                 => Rule::requiredIf(request()->txttipousuario == "talento") . '|nullable',

            'txtregional_aprendiz'               => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->id ||
                    request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->id)) . '|nullable',



            'txtregional_egresado'               => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id)) . '|nullable',

            'txtregional_funcionarioSena'               => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->id)) . '|nullable',

            'txtregional_instructorSena'               => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_INSTRUCTOR_SENA)->first()->id)) . '|nullable',


            'txtcentroformacion_aprendiz'        => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->id ||
                    request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->id)) . '|nullable',


            'txtcentroformacion_egresado'        => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id)) . '|nullable',

            'txtcentroformacion_funcionarioSena'        => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->id)) . '|nullable',

            'txtcentroformacion_instructorSena'        => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_INSTRUCTOR_SENA)->first()->id)) . '|nullable',


            'txtprogramaformacion_aprendiz'      => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->id ||
                    request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->id)) . '|nullable|min:1|max:100',


            'txtprogramaformacion_egresado'      => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id)) . '|nullable|min:1|max:100',


            'txttipoformacion' => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id)) . '|nullable',


            'txtdependencia' => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->id)) . '|nullable',

            'txttipoestudio'            => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO)->first()->id)) . '|nullable',

            'txtuniversidad'            => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO)->first()->id)) . '|nullable|min:1|max:200',



            'txtcarrera'   => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO)->first()->id)) . '|nullable|min:1|max:100',


            'txtempresa'                => Rule::requiredIf(request()->txttipousuario == "talento" &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_EMPRESA)->first()->id)) . '|nullable|min:1|max:200',
        ];
    }

    public function messages()
    {
        return $messages = [
            

            'txtdependencia.required'                 => 'Por favor digite cual dependencia',
            'txtdependencia.min'                      => 'La dependencia debe ser minimo 1 caracter',
            'txtdependencia.max'                      => 'La dependencia debe ser minimo 45 caracteres',
            'txtdependencia.regex'                    => 'El formato del campo La dependencia eso es incorrecto',

            'txtnodo.required'         => 'El nodo es obligatorio.',
            'txttipocontratista.required'         => 'El tipo de contratista es obligatorio.',

            'txtotra_ocupacion.required'          => 'La otra ocupación es obligatoria.',
            'txtotra_ocupacion.regex'             => 'Sólo se permiten caracteres alfabeticos',

            'txtocupaciones.required'             => 'seleccione al menos una ocupación',

            'txtinstitucion.required'             => 'La institución es obligatoria.',
            'txtinstitucion.min'                  => 'La institución  debe ser minimo 1 caracter',
            'txtinstitucion.max'                  => 'La institución  debe ser minimo 100 caracteres',
            'txtinstitucion.regex'                => 'El formato del campo institución es incorrecto',

            'txttitulo.required'                  => 'El titulo es obligatorio.',
            'txttitulo.min'                       => 'El titulo  debe ser minimo 1 caracter',
            'txttitulo.max'                       => 'El titulo  debe ser minimo 200 caracteres',
            'txttitulo.regex'                     => 'El formato del campo titulo es incorrecto',

            'txtfechaterminacion.required'        => 'La fecha de terminación es obligatoria.',
            'txtfechaterminacion.date'            => 'La fecha de terminación no es una fecha válida.',
            'txtfechaterminacion.before_or_equal' => 'La fecha de terminación  debe ser una fecha anterior o igual a la fecha de hoy',

            'txtgrupoinvestigacion.required'      => 'El grupo de investigación es obligatoria.',
            'txtotrotipotalento.required'         => 'El otro tipo de talento es obligatorio.',
            'txtempresa.required'                 => 'La empresa es obligatoria.',
            'txtempresa.min'                      => 'La empresa debe tener minimo 1 caracter',
            'txtempresa.max'                      => 'La empresa debe tener máximo 200 caracteres',

            'txtcarrera.required'    => 'La carrera universitaria es obligatoria.',
            'txtcarrera.min'         => 'La carrera universitaria debe tener minimo 1 caracter',
            'txtcarrera.max'         => 'La carrera universitaria debe tener máximo 100 caracteres',

            'txtuniversidad.required'             => 'La universidad es obligatoria.',
            'txtuniversidad.min'                  => 'La universidad debe tener minimo 1 caracter',
            'txtuniversidad.max'                  => 'La universidad debe tener máximo 200 caracteres',

            'txtprogramaformacion_aprendiz.required'       => 'El programa de formación es obligatorio.',
            'txtprogramaformacion_aprendiz.min'            => 'El programa de formación debe tener minimo 1 caracter',
            'txtprogramaformacion_aprendiz.max'            => 'El programa de formación debe tener máximo 100 caracteres',

            'txtprogramaformacion_egresado.required'       => 'El programa de formación es obligatorio.',
            'txtprogramaformacion_egresado.min'            => 'El programa de formación debe tener minimo 1 caracter',
            'txtprogramaformacion_egresado.max'            => 'El programa de formación debe tener máximo 100 caracteres',

            'txtcentroformacion_aprendiz.required'         => 'El centro de formación es obligatorio.',
            'txtcentroformacion_egresado.required'         => 'El centro de formación es obligatorio.',
            'txtcentroformacion_funcionarioSena.required'         => 'El centro de formación es obligatorio.',
            'txtcentroformacion_instructorSena.required'         => 'El centro de formación es obligatorio.',
            'txtregional_aprendiz.required'                => 'La regional es obligatoria.',
            'txtregional_egresado.required'                => 'La regional es obligatoria.',
            'txtregional_funcionarioSena.required'                => 'La regional es obligatoria.',
            'txtregional_instructorSena.required'                => 'La regional es obligatoria.',
            'txtremember.required' => 'Acepta los términos de uso.'
        ];
    }

}
