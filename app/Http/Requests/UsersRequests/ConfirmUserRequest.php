<?php

namespace App\Http\Requests\UsersRequests;

use App\Models\{TipoTalento};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;


class ConfirmUserRequest extends FormRequest
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
            'role'                      => 'required',
            'txtnodouser'               => Rule::requiredIf(collect(request()->role)->contains(User::IsApoyoTecnico())) . '|nullable',
            'txthonorariouser'          => Rule::requiredIf(collect(request()->role)->contains(User::IsApoyoTecnico()))  . '|nullable|digits_between:1,10|numeric',
            'txtnodoarticulador'        => Rule::requiredIf(collect(request()->role)->contains(User::IsArticulador())) . '|nullable',
            'txthonorarioarticulador'   => Rule::requiredIf(collect(request()->role)->contains(User::IsArticulador()))  . '|nullable|digits_between:1,10|numeric',
            'txtnododinamizador'        => Rule::requiredIf(collect(request()->role)->contains(User::IsDinamizador())) . '|nullable',
            'txtnodogestor'             => Rule::requiredIf(collect (request()->role)->contains(User::IsGestor())) . '|nullable',

            'txtlinea'                  => Rule::requiredIf(collect(request()->role)->contains(User::IsGestor())) . '|nullable',
            'txthonorario'              => Rule::requiredIf(collect(request()->role)->contains(User::IsGestor())) . '|nullable|digits_between:1,10|numeric',
            'txtnodoinfocenter'         => Rule::requiredIf(collect(request()->role)->contains(User::IsInfocenter())) . '|nullable',
            'txtextension'         => Rule::requiredIf(collect(request()->role)->contains(User::IsInfocenter())) . '|nullable|integer|max:99999',
            'txttipotalento'            => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento())) . '|nullable',
            'txtnodoingreso'            => Rule::requiredIf(collect(request()->role)->contains(User::IsIngreso())) . '|nullable',
            'txtregional_aprendiz'      => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                                            (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->id ||
                                            request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->id)) . '|nullable',

            'txtregional_egresado'               => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id)) . '|nullable',

            'txtregional_funcionarioSena'               => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->id)) . '|nullable',

            'txtregional_instructorSena'               => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_INSTRUCTOR_SENA)->first()->id)) . '|nullable',


            'txtcentroformacion_aprendiz'        => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->id ||
                    request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->id)) . '|nullable',


            'txtcentroformacion_egresado'        => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id)) . '|nullable',

            'txtcentroformacion_funcionarioSena'        => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->id)) . '|nullable',

            'txtcentroformacion_instructorSena'        => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_INSTRUCTOR_SENA)->first()->id)) . '|nullable',


            'txtprogramaformacion_aprendiz'      => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->id ||
                    request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->id)) . '|nullable|min:1|max:100',


            'txtprogramaformacion_egresado'      => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id)) . '|nullable|min:1|max:100',


            'txttipoformacion' => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id)) . '|nullable',


            'txtdependencia' => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->id)) . '|nullable',

            'txttipoestudio'            => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO)->first()->id)) . '|nullable',

            'txtuniversidad'            => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO)->first()->id)) . '|nullable|min:1|max:200',



            'txtcarrera'   => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO)->first()->id)) . '|nullable|min:1|max:100',

            'txtempresa'                => Rule::requiredIf(collect(request()->role)->contains(User::IsTalento()) &&
                (request()->txttipotalento == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_EMPRESA)->first()->id)) . '|nullable|min:1|max:200',
        ];
    }

    public function messages()
    {
        return $messages = [
            'role.required'                       => 'Por favor seleccione al menos un rol',
            'txtnodouser.required'         => "El nodo del ".User::IsApoyoTecnico() ." es obligatorio",
            'txthonorariouser.required'               => 'El honorario del ' . User::IsApoyoTecnico() . ' es obligatorio.',
            'txthonorariouser.regex'                  => 'El formato del campo honorario es incorrecto',
            'txthonorariouser.digits_between'         => 'El honorario debe tener entre 6 y 7 digitos',

            'txtnodoarticulador.required'         => "El nodo del ".User::IsArticulador() ." es obligatorio",
            'txthonorarioarticulador.required'               => 'El honorario del ' . User::IsArticulador() . ' es obligatorio.',
            'txthonorarioarticulador.regex'                  => 'El formato del campo honorario es incorrecto',
            'txthonorarioarticulador.digits_between'         => 'El honorario debe tener entre 6 y 7 digitos',

            'txtnododinamizador.required'         => 'El nodo del dinamizador es obligatorio.',
            'txtnodogestor.required'              => 'El nodo es obligatorio.',
            'txtlinea.required'                   => 'La linea es obligatoria.',

            'txthonorario.required'               => 'El honorario es obligatorio.',
            'txthonorario.regex'                  => 'El formato del campo honorario es incorrecto',
            'txthonorario.digits_between'         => 'El honorario debe tener entre 6 y 7 digitos',

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

            'txtnodoingreso.required'             => 'El nodo es obligatorio.',
            'txttipotalento.required'                  => 'El tipo de talento es obligatorio.',
            'txttipoestudio.required'                  => 'El tipo de estudio es obligatorio.',

            'txtnodoinfocenter.required'          => 'El nodo del infocenter es obligatorio',
            'txtextension.required'          => 'El campo extensión es obligatorio',
            'txtextension.numeric'          => 'El campo extensión debe ser numérico',
            'txtextension.between'          => 'El campo extensión tiene que estar entre 1 y 4',
            'txtextension.max'          => 'El campo extensión debe tener máximo 5 caracteres',
        ];
    }

}
