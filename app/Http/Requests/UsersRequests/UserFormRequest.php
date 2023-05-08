<?php

namespace App\Http\Requests\UsersRequests;

use App\Models\Ocupacion;
use App\Models\{TipoTalento};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use \App\Models\Eps;
use App\User;

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
            'txtgenero' => 'required|'.Rule::in([User::IS_MASCULINO, User::IS_FEMENINO, User:: IS_NO_BINARIO]),
            'txtmadrecabezafamilia'                => 'required',
            'txtdesplazadoporviolencia'                => 'required',
            'txtdiscapacidad'          =>  Rule::requiredIf(request()->txtgrado_discapacidad == 1 || request()->txtgrado_discapacidad == '1') . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'txtemail'                  => 'required|email|min:1|max:100|unique:users,email,' . request()->route('id'),
            'txtbarrio'                 => 'required|min:1|max:100',
            'txtdireccion'              => 'required|min:1|max:200',
            'txttelefono'               => 'nullable|digits_between:6,10|numeric',
            'txtcelular'                => 'required|digits_between:10,11|numeric',
            'txtinstitucion'            => 'required|min:1|max:100|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txttitulo'                 => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfechaterminacion'       => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtotraeps'                => Rule::requiredIf(request()->txteps == Eps::where('nombre', Eps::OTRA_EPS)->first()->id) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'txtotra_ocupacion'         => Rule::requiredIf(collect(request()->txtocupaciones)->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id)) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable'
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
            'txtfecha_nacimiento.before_or_equal' => 'La fecha de nacimiento  debe ser una fecha anterior o igual a la actual',

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
            'txttelefono.digits_between'          => 'El teléfono debe tener entre 6 y 10 digitos',

            'txtcelular.required'                  => 'El celular es obligatorio.',
            'txtcelular.numeric'                  => 'El celular debe ser numérico',
            'txtcelular.digits_between'           => 'El celular debe tener entre 10 y 11 digitos',

            'txtgenero.required'                  => 'El género es obligatorio.',
            'txtotraeps.required'                 => 'Por favor ingrese otra eps',
            'txtotraeps.min'                      => 'La otra eps debe ser minimo 1 caracter',
            'txtotraeps.max'                      => 'La otra eps debe ser minimo 45 caracteres',
            'txtotraeps.regex'                    => 'El formato del campo otra eps es incorrecto',
            'txtgrado_discapacidad' => 'El grado de discapacidad es obligatorio',

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

            'txtotra_ocupacion.required'          => 'La otra ocupación es obligatoria.',
            'txtotra_ocupacion.regex'             => 'Sólo se permiten caracteres alfabeticos',

            'txtocupaciones.required'             => 'seleccione al menos una ocupación',
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
