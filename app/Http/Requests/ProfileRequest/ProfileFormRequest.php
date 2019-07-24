<?php

namespace App\Http\Requests\ProfileRequest;

use App\Models\Ocupacion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use \App\Models\Eps;

class ProfileFormRequest extends FormRequest
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
            'txttipo_documento'    => 'required',
            'txtgrado_escolaridad' => 'required',
            'txtgruposanguineo'    => 'required',
            'txtocupaciones'       => 'required',
            'txteps'               => 'required',
            'txtciudad'            => 'required',
            'txtdepartamento'      => 'required',
            // 'txtdocumento'         => ['required|digits_between:6,11|numeric|unique:users,documento,' . $this->route('administrador')],
            'txtdocumento'         => ['required', 'digits_between:6,11', 'numeric', Rule::unique('users', 'documento')->ignore($this->route('perfil'))],
            'txtnombres'           => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtapellidos'         => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfecha_nacimiento'  => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtestrato'           => 'required',
            'txtemail'             => 'required|email|min:1|max:100,|unique:users,email,' . $this->route('perfil'),
            'txtbarrio'            => 'required|min:1|max:100',
            'txtdireccion'         => 'required|min:1|max:200',
            'txttelefono'          => 'nullable|digits_between:6,11|numeric',
            'txtcelular'           => 'nullable|digits_between:10,11|numeric',
            'txtotraeps'           => Rule::requiredIf($this->txteps == Eps::where('nombre', Eps::OTRA_EPS)->first()->id) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'txtinstitucion'       => 'required|min:1|max:100|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txttitulo'            => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfechaterminacion'  => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtotra_ocupacion'    => Rule::requiredIf(collect($this->txtocupaciones)->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id)) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',

        ];
    }

    public function messages()
    {
        return $messages = [
            'txttipo_documento.required'          => 'El tipo de documento es obligatorio.',
            'txtgrado_escolaridad.required'       => 'El grado de escolaridad es obligatorio.',
            'txtgruposanguineo.required'          => 'El grupo sanguíneo es obligatorio.',
            'txteps.required'                     => 'La eps es obligatoria.',
            'txtciudad.required'                  => 'La ciudad es obligatorio.',
            'txtdepartamento.required'            => 'El departamento es obligatorio.',

            'txtdocumento.required'               => 'El documento es obligatorio.',
            'txtdocumento.digits_between'         => 'El documento debe tener entre 6 y 11 digitos',
            'txtdocumento.numeric'                => 'El documento debe ser numérico',
            'txtdocumento.unique'                 => 'El documento ya ha sido registrado',

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
            'txtfecha_nacimiento.before_or_equal' => 'La fecha de nacimiento  debe ser una fecha anterior o igual a la fecha de hoy',

            'txtestrato.required'                 => 'El estrato es obligatorio.',

            'txtemail.required'                   => 'El correo electrónico es obligatorio.',
            'txtemail.min'                        => 'El correo electrónico debe ser minimo 1 caracter',
            'txtemail.max'                        => 'El correo electrónico debe ser máximo 100 caracteres',
            'txtemail.unique'                     => 'El correo electrónico ya ha sido registrado',

            'txtdireccion.min'                    => 'La dirección debe ser minimo 1 caracter',
            'txtdireccion.max'                    => 'La dirección debe ser máximo 200 caracteres',

            'txtbarrio.required'                  => 'El barrio es obligatorio.',
            'txtbarrio.min'                       => 'El barrio debe ser minimo 1 caracter',
            'txtbarrio.max'                       => 'El barrio debe ser máximo 100 caracteres',

            'txttelefono.numeric'                 => 'El telefono debe ser numérico',
            'txttelefono.digits_between'          => 'El telefono debe tener entre 6 y 11 digitos',

            'txtcelular.numeric'                  => 'El celular debe ser numérico',
            'txtcelular.digits_between'           => 'El celular debe tener entre 10 y 11 digitos',

            'txtotraeps.required'                 => 'Por favor ingrese otra eps',
            'txtotraeps.min'                      => 'La otra eps debe ser minimo 1 caracter',
            'txtotraeps.max'                      => 'La otra eps debe ser minimo 45 caracteres',
            'txtotraeps.regex'                    => 'El formato del campo otra eps es incorrecto',

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

            'txtotra_ocupacion.required'          => 'La otra ocupación es obligatoria.',
            'txtocupaciones.required'             => 'seleccione al menos una ocupación',

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
