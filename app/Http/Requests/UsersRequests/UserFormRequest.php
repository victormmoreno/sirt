<?php

namespace App\Http\Requests\UsersRequests;

use App\Models\Perfil;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
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
            'txteps'               => 'required',
            'txtciudad'            => 'required',
            'txtdepartamento'      => 'required',
            'txtdocumento'         => 'required|digits_between:6,11|numeric|unique:users,documento,' . $this->route('id'),
            'txtnombres'           => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtapellidos'         => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfecha_nacimiento'  => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtestrato'           => 'required',
            'txtemail'             => 'required|email|min:1|max:100,|unique:users,email,' . $this->route('id'),
            'txtbarrio'            => 'required|min:1|max:100',
            'txtdireccion'         => 'required|min:1|max:200',
            'txttelefono'          => 'nullable|digits_between:6,11|numeric',
            'txtcelular'           => 'nullable|digits_between:10,11|numeric',
            'txtinstitucion'           => 'required|min:1|max:100|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txttitulo'           => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfechaterminacion'  => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtotraeps'           => Rule::requiredIf($this->txteps == Eps::where('nombre', Eps::OTRA_EPS)->first()->id) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
            'role' => 'required',
            'txtnododinamizador' => Rule::requiredIf(collect($this->role)->contains(User::IsDinamizador())) . '|nullable',
            'txtnodogestor' => Rule::requiredIf(collect($this->role)->contains(User::IsGestor())) . '|nullable',
            'txtlinea' => Rule::requiredIf(collect($this->role)->contains(User::IsGestor())) . '|nullable',
            'txthonorario' => Rule::requiredIf(collect($this->role)->contains(User::IsGestor())) . '|nullable',
            'txtnodoinfocenter' => Rule::requiredIf(collect($this->role)->contains(User::IsInfocenter())) . '|nullable',
            'txtextension' => Rule::requiredIf(collect($this->role)->contains(User::IsInfocenter())) . '|nullable',
            'txtperfil' => Rule::requiredIf(collect($this->role)->contains(User::IsTalento())) . '|nullable',
            'txtregional' => Rule::requiredIf($this->txtperfil == Perfil::where('nombre',Perfil::IsAprendizSenaSinApoyo())->first()->id || $this->txtperfil == Perfil::where('nombre',Perfil::IsAprendizSenaConApoyo())->first()->id || $this->txtperfil == Perfil::where('nombre',Perfil::IsEgresadoSena())->first()->id ) . '|nullable',
            'txtcentroformacion' => Rule::requiredIf($this->txtperfil == Perfil::where('nombre',Perfil::IsAprendizSenaSinApoyo())->first()->id || $this->txtperfil == Perfil::where('nombre',Perfil::IsAprendizSenaConApoyo())->first()->id || $this->txtperfil == Perfil::where('nombre',Perfil::IsEgresadoSena())->first()->id) . '|nullable',
            'txtuniversidad' => Rule::requiredIf($this->txtperfil == Perfil::where('nombre',Perfil::IsEstudianteUniversitarioPregrado())->first()->id || $this->txtperfil == Perfil::where('nombre',Perfil::IsEstudianteUniversitarioPostgrado())->first()->id) . '|nullable',
            'txtempresa' => Rule::requiredIf($this->txtperfil == Perfil::where('nombre',Perfil::IsFuncionarioEmpresaPublica())->first()->id || $this->txtperfil == Perfil::where('nombre',Perfil::IsFuncionarioMicroempresa())->first()->id|| $this->txtperfil == Perfil::where('nombre',Perfil::IsFuncionarioMedianaEmpresa())->first()->id || $this->txtperfil == Perfil::where('nombre',Perfil::IsFuncionarioGrandeEmpresa())->first()->id) . '|nullable',
            'txtotrotipotalento' => Rule::requiredIf($this->txtperfil == Perfil::where('nombre',Perfil::IsOtro())->first()->id) . '|nullable',
            'txtgrupoinvestigacion' => Rule::requiredIf($this->txtperfil == Perfil::where('nombre',Perfil::IsInvestigador())->first()->id) . '|nullable|exists:gruposinvestigacion,codigo_grupo',

        ];
    }


    public function messages()
    {
        return $messages = [
            'txttipo_documento.required'          => 'El :attribute es obligatorio.',
            'txtgrado_escolaridad.required'       => 'El grado de escolaridad es obligatorio.',
            'txtgruposanguineo.required'          => 'El :attribute es obligatorio.',
            'txteps.required'                     => 'La :attribute es obligatoria.',
            'txtciudad.required'                  => 'El :attribute es obligatorio.',
            'txtdepartamento.required'            => 'El :attribute es obligatorio.',

            'txtdocumento.required'               => 'El :attribute es obligatorio.',
            'txtdocumento.digits_between'         => 'El :attribute debe tener entre 6 y 11 digitos',
            'txtdocumento.numeric'                => 'El :attribute debe ser numérico',
            'txtdocumento.unique'                 => 'El :attribute ya ha sido registrado',

            'txtnombres.required'                 => 'Los :attribute son obligatorios.',
            'txtnombres.min'                      => 'Los :attribute deben ser minimo 1 caracter',
            'txtnombres.max'                      => 'Los :attribute deben ser máximo 45 caracteres',
            'txtnombres.regex'                    => 'El formato del campo :attribute es incorrecto',

            'txtapellidos.required'               => 'Los :attribute son obligatorios.',
            'txtapellidos.min'                    => 'Los :attribute deben ser minimo 1 caracter',
            'txtapellidos.max'                    => 'Los :attribute deben ser máximo 45 caracteres',
            'txtapellidos.regex'                  => 'El formato del campo :attribute es incorrecto',

            'txtfecha_nacimiento.required'        => 'La :attribute es obligatoria.',
            'txtfecha_nacimiento.date'            => 'La :attribute no es una fecha válida.',
            'txtfecha_nacimiento.before_or_equal' => 'La :attribute  debe ser una fecha anterior o igual a 2019-06-11.',

            'txtestrato.required'                 => 'El :attribute es obligatorio.',

            'txtemail.required'                   => 'El :attribute es obligatorio.',
            'txtemail.min'                        => 'El :attribute debe ser minimo 1 caracter',
            'txtemail.max'                        => 'El :attribute debe ser máximo 100 caracteres',
            'txtemail.unique'                     => 'El :attribute ya ha sido registrado',

            'txtdireccion.required'               => 'La :attribute es obligatoria.',
            'txtdireccion.min'                    => 'La :attribute debe ser minimo 1 caracter',
            'txtdireccion.max'                    => 'La :attribute debe ser máximo 200 caracteres',

            'txtbarrio.required'                  => 'El :attribute es obligatori.',
            'txtbarrio.min'                       => 'El :attribute debe ser minimo 1 caracter',
            'txtbarrio.max'                       => 'El :attribute debe ser máximo 100 caracteres',

            'txttelefono.numeric'                 => 'El :attribute debe ser numérico',
            'txttelefono.digits_between'          => 'El :attribute debe tener entre 6 y 11 digitos',

            'txtcelular.numeric'                  => 'El :attribute debe ser numérico',
            'txtcelular.digits_between'           => 'El :attribute debe tener entre 10 y 11 digitos',

            'txtgenero.required'                  => 'El :attribute es obligatorio.',
            'txtotraeps.required'                  => 'Por favor ingrese :attribute',
            'txtotraeps.min'                  => 'El :attribute debe ser minimo 1 caracter',
            'txtotraeps.max'                  => 'El :attribute debe ser minimo 45 caracteres',
            'txtotraeps.regex'                  => 'El formato del campo :attribute es incorrecto',

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
            'txtotraeps'            => 'otra eps',
        ];
    }
}
