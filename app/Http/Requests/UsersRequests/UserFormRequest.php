<?php

namespace App\Http\Requests\UsersRequests;

use App\Models\Ocupacion;
use App\Models\Perfil;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use \App\Models\Eps;

class UserFormRequest extends FormRequest
{

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    // public function withValidator($validator)
    // {
    //     // $validator->after(function ($validator) {
    //     //     $userdinamizador = User::with('dinamizador.nodo')->whereHas('dinamizador.nodo', function ($query) {
    //     //         $query->where('id', $this->txtnododinamizador);
    //     //     })->whereHas('roles', function ($query) {
    //     //         $query->where('name', 'dinamizador');
    //     //     })->get();

    //     //     // dd($userdinamizador);
    //     //     $userdinamizador->filter(function ($value, $key) {
    //     //         dd($value->id == $this->route('id'));
    //     //     });

    //     //     if ($userdinamizador->count() >= 1 ) {
    //     //         $validator->errors()->add('txtnododinamizador', 'Ya hay un dimanizador registrado en el nodo. Si desea registrar otro dinamizador por favor elimine el rol dinamizador a todos los dinamizadores asociados al nodo' );
    //     //     }

    //     // });

    // }
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
            'txttipo_documento'         => 'required',
            'txtocupaciones'            => 'required',
            'txtgrado_escolaridad'      => 'required',
            'txtgruposanguineo'         => 'required',
            'txteps'                    => 'required',
            'txtciudad'                 => 'required',
            'txtciudadexpedicion'       => 'required',
            'txtdepartamento'           => 'required',
            'txtdepartamento'           => 'required',
            'txtdepartamentoexpedicion' => 'required',
            'txtdocumento'              => 'required|digits_between:6,11|numeric|unique:users,documento,' . $this->route('id'),
            'txtnombres'                => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtapellidos'              => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfecha_nacimiento'       => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtestrato'                => 'required',
            'txtemail'                  => 'required|email|min:1|max:100|unique:users,email,' . $this->route('id'),
            'txtbarrio'                 => 'required|min:1|max:100',
            'txtdireccion'              => 'required|min:1|max:200',
            'txttelefono'               => 'nullable|digits_between:6,11|numeric',
            'txtcelular'                => 'nullable|digits_between:10,11|numeric',
            'txtinstitucion'            => 'required|min:1|max:100|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txttitulo'                 => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfechaterminacion'       => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtotraeps'                => Rule::requiredIf($this->txteps == Eps::where('nombre', Eps::OTRA_EPS)->first()->id) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'txtotra_ocupacion'         => Rule::requiredIf(collect($this->txtocupaciones)->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id)) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'role'                      => 'required',
            'txtnododinamizador'        => Rule::requiredIf(collect($this->role)->contains(User::IsDinamizador())) . '|nullable',
            'txtnodogestor'             => Rule::requiredIf(collect($this->role)->contains(User::IsGestor())) . '|nullable',
            'txtlinea'                  => Rule::requiredIf(collect($this->role)->contains(User::IsGestor())) . '|nullable',
            'txthonorario'              => Rule::requiredIf(collect($this->role)->contains(User::IsGestor())) . '|nullable|digits_between:1,10|numeric',
            'txtnodoinfocenter'         => Rule::requiredIf(collect($this->role)->contains(User::IsInfocenter())) . '|nullable',
            'txtextension'              => Rule::requiredIf(collect($this->role)->contains(User::IsInfocenter())) . '|nullable|digits_between:1,7|numeric',
            'txtperfil'                 => Rule::requiredIf(collect($this->role)->contains(User::IsTalento())) . '|nullable',
            'txtnodoingreso'            => Rule::requiredIf(collect($this->role)->contains(User::IsIngreso())) . '|nullable',
            'txtregional'               => Rule::requiredIf(collect($this->role)->contains(User::IsTalento()) && 
                ($this->txtperfil == Perfil::where('nombre', Perfil::IsAprendizSenaSinApoyo())->first()->id || 
                $this->txtperfil == Perfil::where('nombre', Perfil::IsAprendizSenaConApoyo())->first()->id || 
                $this->txtperfil == Perfil::where('nombre', Perfil::IsEgresadoSena())->first()->id)) . '|nullable',






            'txtcentroformacion'        => Rule::requiredIf(collect($this->role)->contains(User::IsTalento()) && 
                ($this->txtperfil == Perfil::where('nombre', Perfil::IsAprendizSenaSinApoyo())->first()->id || 
                $this->txtperfil == Perfil::where('nombre', Perfil::IsAprendizSenaConApoyo())->first()->id || 
                $this->txtperfil == Perfil::where('nombre', Perfil::IsEgresadoSena())->first()->id)) . '|nullable',




            'txtprogramaformacion'      => Rule::requiredIf(collect($this->role)->contains(User::IsTalento()) && 
                ($this->txtperfil == Perfil::where('nombre', Perfil::IsAprendizSenaSinApoyo())->first()->id || 
                $this->txtperfil == Perfil::where('nombre', Perfil::IsAprendizSenaConApoyo())->first()->id || 
                $this->txtperfil == Perfil::where('nombre', Perfil::IsEgresadoSena())->first()->id)) . '|nullable|min:1|max:100',



            'txtuniversidad'            => Rule::requiredIf(collect($this->role)->contains(User::IsTalento()) && 
                ($this->txtperfil == Perfil::where('nombre', Perfil::IsEstudianteUniversitarioPregrado())->first()->id || $this->txtperfil == Perfil::where('nombre', Perfil::IsEstudianteUniversitarioPostgrado())->first()->id)) . '|nullable|min:1|max:200',



            'txtcarrerauniversitaria'   => Rule::requiredIf(collect($this->role)->contains(User::IsTalento()) && 
                ($this->txtperfil == Perfil::where('nombre', Perfil::IsEstudianteUniversitarioPregrado())->first()->id || $this->txtperfil == Perfil::where('nombre', Perfil::IsEstudianteUniversitarioPostgrado())->first()->id)) . '|nullable|min:1|max:100',


            'txtempresa'                => Rule::requiredIf(collect($this->role)->contains(User::IsTalento()) && 
                ($this->txtperfil == Perfil::where('nombre', Perfil::IsFuncionarioEmpresaPublica())->first()->id || $this->txtperfil == Perfil::where('nombre', Perfil::IsFuncionarioMicroempresa())->first()->id || $this->txtperfil == Perfil::where('nombre', Perfil::IsFuncionarioMedianaEmpresa())->first()->id || $this->txtperfil == Perfil::where('nombre', Perfil::IsFuncionarioGrandeEmpresa())->first()->id)) . '|nullable|min:1|max:200',


            'txtotrotipotalento'        => Rule::requiredIf(collect($this->role)->contains(User::IsTalento()) && 
                ($this->txtperfil == Perfil::where('nombre', Perfil::IsOtro())->first()->id)) . '|nullable',



            'txtgrupoinvestigacion'     => Rule::requiredIf(collect($this->role)->contains(User::IsTalento()) && 
                $this->txtperfil == Perfil::where('nombre', Perfil::IsInvestigador())->first()->id) . '|nullable|exists:entidades,nombre',

        ];
    }

    public function messages()
    {
        return $messages = [
            'txttipo_documento.required'          => 'El tipo documento es obligatorio.',
            'txtgrado_escolaridad.required'       => 'El grado de escolaridad es obligatorio.',
            'txtgruposanguineo.required'          => 'El grupo sanguineo es obligatorio.',
            'txteps.required'                     => 'La la eps es obligatoria.',
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

            'txttelefono.numeric'                 => 'El telefono debe ser numérico',
            'txttelefono.digits_between'          => 'El telefono debe tener entre 6 y 11 digitos',

            'txtcelular.numeric'                  => 'El celular debe ser numérico',
            'txtcelular.digits_between'           => 'El celular debe tener entre 10 y 11 digitos',

            'txtgenero.required'                  => 'El genero es obligatorio.',
            'txtotraeps.required'                 => 'Por favor ingrese otra eps',
            'txtotraeps.min'                      => 'La otra eps debe ser minimo 1 caracter',
            'txtotraeps.max'                      => 'La otra eps debe ser minimo 45 caracteres',
            'txtotraeps.regex'                    => 'El formato del campo otra eso es incorrecto',

            'role.required'                       => 'Por favor seleccione al menos un rol',
            'txtnododinamizador.required'         => 'El nodo del dinamizador es obligatorio.',
            'txtnodogestor.required'              => 'El nodo del gestor es obligatorio.',
            'txtlinea.required'                   => 'La linea es obligatoria.',

            'txthonorario.required'               => 'El honorario es obligatorio.',
            'txthonorario.regex'                  => 'El formato del campo honorario es incorrecto',
            'txthonorario.digits_between'         => 'El honorario debe tener entre 6 y 7 digitos',

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

            'txtcarrerauniversitaria.required'    => 'La carrera universitaria es obligatoria.',
            'txtcarrerauniversitaria.min'         => 'La carrera universitaria debe tener minimo 1 caracter',
            'txtcarrerauniversitaria.max'         => 'La carrera universitaria debe tener máximo 100 caracteres',

            'txtuniversidad.required'             => 'La universidad es obligatoria.',
            'txtuniversidad.min'                  => 'La universidad debe tener minimo 1 caracter',
            'txtuniversidad.max'                  => 'La universidad debe tener máximo 200 caracteres',

            'txtprogramaformacion.required'       => 'El programa de formación es obligatorio.',
            'txtprogramaformacion.min'            => 'El programa de formación debe tener minimo 1 caracter',
            'txtprogramaformacion.max'            => 'El programa de formación debe tener máximo 100 caracteres',

            'txtcentroformacion.required'         => 'El centro de formación es obligatorio.',
            'txtregional.required'                => 'La regional es obligatoria.',
            'txtnodoingreso.required'             => 'El nodo es obligatorio.',
            'txtperfil.required'                  => 'El tipo de talento es obligatorio.',

            'txtextension.required'               => 'La extensión es obligatoria.',
            'txtextension.numeric'                => 'La extensión debe ser numérica',
            'txtextension.digits_between'         => 'La extensión debe tener entre 6 y 7 digitos',
            'txtnodoinfocenter.required'          => 'El nodo del infocenter es obligatorio',
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
            'txtgenero'            => 'genero',
            'txtotraeps'           => 'otra eps',
        ];
    }
}
