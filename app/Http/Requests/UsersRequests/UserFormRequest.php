<?php

namespace App\Http\Requests\UsersRequests;

use App\Models\Ocupacion;
use App\Models\{TipoTalento};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use \App\Models\Eps;

class UserFormRequest extends FormRequest
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
            'txttipo_documento'         => 'required',
            'txtocupaciones'            => 'required',
            'txtgrado_escolaridad'      => 'required',
            'txtgruposanguineo'         => 'required',
            'txteps'                    => 'required',
            'txtciudad'                 => 'required',
            'txtciudadexpedicion'       => 'required',
            'txtdepartamento'           => 'required',
            'txtdepartamento'           => 'required',
            'txtetnias'           => 'required',
            'txtdepartamentoexpedicion' => 'required',
            'txtdocumento'              => 'required|digits_between:6,11|numeric|unique:users,documento,' . request()->route('id'),
            'txtnombres'                => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtapellidos'              => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfecha_nacimiento'       => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtestrato'                => 'required',
            'txtgrado_discapacidad'    => 'required',
            'txtmadrecabezafamilia'                => 'required',
            'txtdesplazadoporviolencia'                => 'required',
            'txtdiscapacidad'          =>  Rule::requiredIf(request()->txtgrado_discapacidad == 1 || request()->txtgrado_discapacidad == '1') . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'txtemail'                  => 'required|email|min:1|max:100|unique:users,email,' . request()->route('id'),
            'txtbarrio'                 => 'required|min:1|max:100',
            'txtdireccion'              => 'required|min:1|max:200',
            'txttelefono'               => 'nullable|digits_between:6,11|numeric',
            'txtcelular'                => 'nullable|digits_between:10,11|numeric',
            'txtinstitucion'            => 'required|min:1|max:100|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txttitulo'                 => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfechaterminacion'       => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtotraeps'                => Rule::requiredIf(request()->txteps == Eps::where('nombre', Eps::OTRA_EPS)->first()->id) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'txtotra_ocupacion'         => Rule::requiredIf(collect(request()->txtocupaciones)->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id)) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'txttipousuario'                      => 'required|'. Rule::in(['talento', 'contratista']),
            'txtnodo'        => Rule::requiredIf(request()->txttipousuario == "contratista") . '|nullable',
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
            'txtremember'         => 'required',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtetnias.required'                  => 'La Etnia es obligatoria.',
            'txttipo_documento.required'          => 'El tipo documento es obligatorio.',
            'txttipoestudio.required'          => 'El tipo de estudio es obligatorio.',
            'txttipoformacion.required'          => 'El tipo de formación es obligatorio.',

            'txtgrado_escolaridad.required'       => 'El grado de escolaridad es obligatorio.',
            'txtgruposanguineo.required'          => 'El grupo sanguineo es obligatorio.',
            'txteps.required'                     => 'La eps es obligatoria.',
            'txtciudad.required'                  => 'La ciudad de residencia es obligatoria.',
            'txtciudadexpedicion.required'        => 'La ciudad de expedición del documento es obligatoria.',
            'txtdepartamento.required'            => 'El departamento de residencia es obligatorio.',
            'txtdepartamentoexpedicion.required'  => 'El departamento de expedición del documento es obligatorio.',

            'txtdocumento.required'               => 'El número de documento es obligatorio.',
            'txtdocumento.digits_between'         => 'El número de documento debe tener entre 6 y 11 digitos',
            'txtdocumento.numeric'                => 'El número de documento debe ser numérico',
            'txtdocumento.unique'                 => 'El número de documento ya ha sido registrado',

            'txtnombres.required'                 => 'Los nombres son obligatorios.',
            'txtnombres.min'                      => 'Los nombres deben ser minimo 1 caracter',
            'txtnombres.max'                      => 'Los nombres deben ser máximo 45 caracteres',
            'txtnombres.regex'                    => 'El formato del campo nombres es incorrecto',

            'txtapellidos.required'               => 'Los apellidos son obligatorios.',
            'txtapellidos.min'                    => 'Los apellidos deben ser minimo 1 caracter',
            'txtapellidos.max'                    => 'Los apellidos deben ser máximo 45 caracteres',
            'txtapellidos.regex'                  => 'El formato del campo apellidos es incorrecto',

            'txtfecha_nacimiento.required'        => 'La fecha de nacimiento es obligatoria.',
            'txtfecha_nacimiento.date'            => 'La fecha de nacimiento no es una fecha válida.',
            'txtfecha_nacimiento.before_or_equal' => 'La fecha de nacimiento  debe ser una fecha anterior o igual a 2019-06-11.',

            'txtestrato.required'                 => 'El estrato es obligatorio.',

            'txtemail.required'                   => 'El correo electrónico es obligatorio.',
            'txtemail.min'                        => 'El correo electrónico debe ser minimo 1 caracter',
            'txtemail.max'                        => 'El correo electrónico debe ser máximo 100 caracteres',
            'txtemail.unique'                     => 'El correo electrónico ya ha sido registrado',

            'txtdireccion.required'               => 'La dirección es obligatoria.',
            'txtdireccion.min'                    => 'La dirección debe ser minimo 1 caracter',
            'txtdireccion.max'                    => 'La dirección debe ser máximo 200 caracteres',

            'txtbarrio.required'                  => 'El barrio es obligatorio.',
            'txtbarrio.min'                       => 'El barrio debe ser minimo 1 caracter',
            'txtbarrio.max'                       => 'El barrio debe ser máximo 100 caracteres',

            'txttelefono.numeric'                 => 'El teléfono debe ser numérico',
            'txttelefono.digits_between'          => 'El teléfono debe tener entre 6 y 11 digitos',

            'txtcelular.numeric'                  => 'El celular debe ser numérico',
            'txtcelular.digits_between'           => 'El celular debe tener entre 10 y 11 digitos',

            'txtgenero.required'                  => 'El género es obligatorio.',
            'txtotraeps.required'                 => 'Por favor ingrese otra eps',
            'txtotraeps.min'                      => 'La otra eps debe ser minimo 1 caracter',
            'txtotraeps.max'                      => 'La otra eps debe ser minimo 45 caracteres',
            'txtotraeps.regex'                    => 'El formato del campo otra eps es incorrecto',

            'txtmadrecabezafamilia.required'                  => 'El campo es obligatorio.',
            'txtdesplazadoporviolencia.required'                  => 'El campo es obligatorio.',

            'txtdiscapacidad.required'                 => 'Por favor digite cual grado de discapacidad',
            'txtdiscapacidad.min'                      => 'El grado de discapacidad debe ser minimo 1 caracter',
            'txtdiscapacidad.max'                      => 'El grado de discapacidad debe ser minimo 45 caracteres',
            'txtdiscapacidad.regex'                    => 'El formato del campo cual eso es incorrecto',

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

    public function attributes()
    {
        return [
            'txttipo_documento'    => 'tipo de documento',
            'txtgrado_escolaridad' => 'grado escolaridad',
            'txtgruposanguineo'    => 'grupo sanguíneo',
            'txteps'               => 'eps',
            'txtciudad'            => 'ciudad',
            'txtdepartamento'      => 'departamento',
            'txtdocumento'         => 'número de documento',
            'txtnombres'           => 'nombres',
            'txtapellidos'         => 'apellidos',
            'txtfecha_nacimiento'  => 'fecha de nacimiento',
            'txtestrato'           => 'estrato',
            'txtemail'             => 'correo electrónico',
            'txtdireccion'         => 'dirección',
            'txtbarrio'            => 'barrio',
            'txttelefono'          => 'telefono',
            'txtcelular'           => 'celular',
            'txtotraeps'           => 'otra eps',
        ];
    }
}
