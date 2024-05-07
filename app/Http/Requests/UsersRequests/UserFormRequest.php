<?php

namespace App\Http\Requests\UsersRequests;

use App\Models\Ocupacion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Eps;
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
            'tipo_documento'         => 'required',
            'documento'              => 'required|digits_between:6,11|numeric|unique:users,documento,' . request()->route('id'),
            'departamentoexpedicion' => 'required',
            'ciudadexpedicion'       => 'required',
            'email'                  => 'required|email|min:1|max:100|unique:users,email,' . request()->route('id'),
            'telefono'               => 'nullable|digits_between:6,10|numeric',
            'celular'                => 'required|digits_between:10,11|numeric',
            'departamento'           => 'required',
            'ciudad'                 => 'required',
            'barrio'                 => 'required|min:1|max:100',
            'nombres'                => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'apellidos'              => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'fechanacimiento'        => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'gruposanguineo'         => 'required',
            'estrato'                => 'required',
            'etnia'                  => 'required',
            'eps'                    => 'required',
            'otraeps'                => Rule::requiredIf(request()->eps == Eps::where('nombre', Eps::OTRA_EPS)->first()->id) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'gradodiscapacidad'      => 'required',
            'discapacidad'           =>  Rule::requiredIf(request()->gradodiscapacidad == 1 || request()->gradodiscapacidad == '1') . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'madrecabezafamilia'     => 'required',
            'desplazadoporviolencia' => 'required',
            'genero'                 => 'required|'.Rule::in([User::IS_MASCULINO, User::IS_FEMENINO, User:: IS_NO_BINARIO]),
            'institucion'            => 'required|min:1|max:100|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'gradoescolaridad'       => 'required',
            'titulo'                 => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'fechaterminacion'       => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'ocupaciones'            => 'required',
            'otra_ocupacion'         => Rule::requiredIf(collect(request()->ocupaciones)->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id)) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'remember'               => 'required'
        ];
    }

    public function messages()
    {
        return [
            'tipo_documento.required'          => 'El tipo documento es obligatorio.',
            'documento.required'               => 'El número de documento es obligatorio.',
            'documento.digits_between'         => 'El número de documento debe tener entre 6 y 11 digitos',
            'documento.numeric'                => 'El número de documento debe ser numérico',
            'documento.unique'                 => 'El número de documento ya ha sido registrado',
            'departamentoexpedicion.required'  => 'El departamento de expedición del documento es obligatorio.',
            'ciudadexpedicion.required'        => 'La ciudad de expedición del documento es obligatoria.',
            'email.required'                   => 'El correo electrónico es obligatorio.',
            'email.min'                        => 'El correo electrónico debe ser minimo 1 caracter',
            'email.max'                        => 'El correo electrónico debe ser máximo 100 caracteres',
            'email.unique'                     => 'El correo electrónico ya ha sido registrado',
            'telefono.numeric'                 => 'El teléfono debe ser numérico',
            'telefono.digits_between'          => 'El teléfono debe tener entre 6 y 10 digitos',
            'celular.required'                 => 'El celular es obligatorio.',
            'celular.numeric'                  => 'El celular debe ser numérico',
            'celular.digits_between'           => 'El celular debe tener entre 10 y 11 digitos',
            'departamento.required'            => 'El departamento de residencia es obligatorio.',
            'ciudad.required'                  => 'La ciudad de residencia es obligatoria.',
            'barrio.required'                  => 'El barrio es obligatorio.',
            'barrio.min'                       => 'El barrio debe ser minimo 1 caracter',
            'barrio.max'                       => 'El barrio debe ser máximo 100 caracteres',
            'nombres.required'                 => 'Los nombres son obligatorios.',
            'nombres.min'                      => 'Los nombres deben ser minimo 1 caracter',
            'nombres.max'                      => 'Los nombres deben ser máximo 45 caracteres',
            'nombres.regex'                    => 'El formato del campo nombres es incorrecto',
            'apellidos.required'               => 'Los apellidos son obligatorios.',
            'apellidos.min'                    => 'Los apellidos deben ser minimo 1 caracter',
            'apellidos.max'                    => 'Los apellidos deben ser máximo 45 caracteres',
            'apellidos.regex'                  => 'El formato del campo apellidos es incorrecto',
            'fechanacimiento.required'         => 'La fecha de nacimiento es obligatoria.',
            'fechanacimiento.date'             => 'La fecha de nacimiento no es una fecha válida.',
            'fechanacimiento.before_or_equal'  => 'La fecha de nacimiento  debe ser una fecha anterior o igual a la actual',
            'gruposanguineo.required'          => 'El grupo sanguineo es obligatorio.',
            'estrato.required'                 => 'El estrato es obligatorio.',
            'etnia.required'                   => 'La etnia es obligatoria.',
            'eps.required'                     => 'La eps es obligatoria.',
            'otraeps.required'                 => 'Por favor ingrese otra eps',
            'otraeps.min'                      => 'La otra eps debe ser minimo 1 caracter',
            'otraeps.max'                      => 'La otra eps debe ser minimo 45 caracteres',
            'otraeps.regex'                    => 'El formato del campo otra eps es incorrecto',
            'gradodiscapacidad'                => 'El grado de discapacidad es obligatorio',
            'discapacidad.required'            => 'Por favor digite cual grado de discapacidad',
            'discapacidad.min'                 => 'El grado de discapacidad debe ser minimo 1 caracter',
            'discapacidad.max'                 => 'El grado de discapacidad debe ser minimo 45 caracteres',
            'discapacidad.regex'               => 'El formato del campo cual eso es incorrecto',
            'madrecabezafamilia.required'      => 'El campo es obligatorio.',
            'desplazadoporviolencia.required'  => 'El campo es obligatorio.',
            'genero.required'                  => 'El género es obligatorio.',
            'institucion.required'             => 'La institución es obligatoria.',
            'institucion.min'                  => 'La institución  debe ser minimo 1 caracter',
            'institucion.max'                  => 'La institución  debe ser minimo 100 caracteres',
            'institucion.regex'                => 'El formato del campo institución es incorrecto',
            'gradoescolaridad.required'        => 'El grado de escolaridad es obligatorio.',
            'titulo.required'                  => 'El titulo es obligatorio.',
            'titulo.min'                       => 'El titulo  debe ser minimo 1 caracter',
            'titulo.max'                       => 'El titulo  debe ser minimo 200 caracteres',
            'titulo.regex'                     => 'El formato del campo titulo es incorrecto',
            'fechaterminacion.required'        => 'La fecha de terminación es obligatoria.',
            'fechaterminacion.date'            => 'La fecha de terminación no es una fecha válida.',
            'fechaterminacion.before_or_equal' => 'La fecha de terminación  debe ser una fecha anterior o igual a la fecha de hoy',
            'ocupaciones.required'             => 'seleccione al menos una ocupación',
            'otra_ocupacion.required'          => 'La otra ocupación es obligatoria.',
            'otra_ocupacion.regex'             => 'Sólo se permiten caracteres alfabeticos',
            'remember.required'                => 'Acepta los términos de uso.',
        ];
    }

    public function attributes()
    {
        return [
            'tipo_documento'    => 'tipo de documento',
            'documento'         => 'número de documento',
            'grado_escolaridad' => 'grado escolaridad',
            'gruposanguineo'    => 'grupo sanguíneo',
            'fecha_nacimiento'  => 'fecha de nacimiento',
            'email'             => 'correo electrónico',
            'otraeps'           => 'otra eps',
        ];
    }
}
