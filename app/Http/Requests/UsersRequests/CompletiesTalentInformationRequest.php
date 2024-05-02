<?php

namespace App\Http\Requests\UsersRequests;

use App\Models\Ocupacion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CompletiesTalentInformationRequest extends FormRequest
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
            'talent_type'            => 'required',
            'regional'               => Rule::requiredIf(
                request()->talent_type == 1 ||
                    request()->talent_type == 2 ||
                    request()->talent_type == 3 ||
                    request()->talent_type == 4 ||
                    request()->talent_type == 5
            ) . '|nullable',
            'training_center'        => Rule::requiredIf(
                request()->talent_type == 1 ||
                    request()->talent_type == 2 ||
                    request()->talent_type == 3 ||
                    request()->talent_type == 4 ||
                    request()->talent_type == 5
            ) . '|nullable',
            'training_program' => Rule::requiredIf(
                request()->talent_type == 1 ||
                    request()->talent_type == 2 ||
                    request()->talent_type == 3
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'formation_type'       => Rule::requiredIf(
                request()->talent_type == 3
            ) . '|nullable',
            'study_type'                  => Rule::requiredIf(
                request()->talent_type == 8
            ) . '|nullable',
            'university'                  => Rule::requiredIf(
                request()->talent_type == 8
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'career'                  => Rule::requiredIf(
                request()->talent_type == 8
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'company'                  => Rule::requiredIf(
                request()->talent_type == 6 ||
                    request()->talent_type == 9
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'dependency'                  => Rule::requiredIf(
                request()->talent_type == 5
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'txtocupaciones' => 'required',
            'txtotra_ocupacion'  => Rule::requiredIf(collect(request()->txtocupaciones)->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id)) . '|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/|nullable',
        ];
    }

    public function messages()
    {
        return [
            'talent_type.required'              => 'El campo tipo talento es obligatorio.',
            'regional.required'                 => 'El campo regional es obligatorio.',
            'training_center.required'          => 'El campo centro de formación es obligatorio.',
            'training_program.required'         => 'El campo programa de formación es obligatorio.',
            'training_program.min'              => 'El campo programa de formación debe ser minimo 1 caracter',
            'training_program.max'              => 'El campo programa de formación debe ser máximo 300 caracteres',
            'training_program.regex'            => 'El campo programa de formación debe tener un formato alfanumérico',
            'formation_type.required' => 'El campo tipo formación es obligatorio.',
            'study_type.required'   => 'El campo tipo estudio es obligatorio.',
            'university.required' => 'El campo universidad es obligatorio.',
            'university.min' => 'El campo universidad debe ser minimo 1 caracter',
            'university.max' => 'El campo universidad debe ser máximo 300 caracteres',
            'university.regex' => 'El campo universidad debe tener un formato alfanumérico',
            'career.required' => 'El campo carrera es obligatorio.',
            'career.min' => 'El campo carrera debe ser minimo 1 caracter',
            'career.max' => 'El campo carrera debe ser máximo 300 caracteres',
            'career.regex' => 'El campo carrera debe tener un formato alfanumérico',
            'company.required' => 'El campo empresa es obligatorio.',
            'company.min' => 'El campo empresa debe ser minimo 1 caracter',
            'company.max' => 'El campo empresa debe ser máximo 300 caracteres',
            'company.regex' => 'El campo empresa debe tener un formato alfanumérico',
            'dependency.required' => 'El campo dependencia es obligatorio.',
            'dependency.min' => 'El campo dependencia debe ser minimo 1 caracter',
            'dependency.max' => 'El campo dependencia debe ser máximo 300 caracteres',
            'dependency.regex' => 'El campo dependencia debe tener un formato alfanumérico',
            'txtocupaciones.required'  => 'El campo ocupaciones es obligatorio.',
            'txtotra_ocupacion.required' => 'El campo otra ocupación es obligatorio.',
            'txtotra_ocupacion.min' => 'El campo otra ocupación debe ser minimo 1 caracter',
            'txtotra_ocupacion.max' => 'El campo otra ocupación debe ser máximo 45 caracteres',
            'txtotra_ocupacion.regex' => 'Sólo se permiten caracteres alfabeticos',

        ];
    }
}
