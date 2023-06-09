<?php

namespace App\Http\Requests\UsersRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;

class RoleContratInformationRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'role'            => 'required',
            'activator_type_relationship'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsActivador())
                ) . '|nullable',
            'activator_code_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsActivador()) &&
                    request()->activator_type_relationship == 0
                ) . '|min:1|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'activator_start_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsActivador()) &&
                    request()->activator_type_relationship == 0
                ) . '|date_format:"Y-m-d"|nullable',
            'activator_end_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsActivador()) &&
                    request()->activator_type_relationship == 0
                ) . '|date_format:"Y-m-d"|after_or_equal:activator_start_date_contract|nullable',
            'activator_contract_value_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsActivador()) &&
                    request()->activator_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|regex:/^(\d+|\d+(\.\d{1,2})?|(\.\d{1,2}))$/|nullable',
            'activator_fees_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsActivador()) &&
                    request()->activator_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|regex:/^(\d+|\d+(\.\d{1,2})?|(\.\d{1,2}))$/|nullable',


            'dynamizer_node'        => Rule::requiredIf(
                        collect(request()->role)->contains(User::IsDinamizador())
                    ) . '|nullable',
            'dynamizer_type_relationship'        => Rule::requiredIf(
                    collect(request()->role)->contains(User::IsDinamizador())
                    ) . '|nullable',
            'dynamizer_code_contract' => Rule::requiredIf(
                    collect(request()->role)->contains(User::IsDinamizador()) &&
                        request()->dynamizer_type_relationship == 0
                    ) . '|min:1|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'dynamizer_start_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsDinamizador()) &&
                    request()->dynamizer_type_relationship == 0
                ) . '|date_format:"Y-m-d"|nullable',
            'dynamizer_end_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsDinamizador()) &&
                    request()->dynamizer_type_relationship == 0
                ) . '|date_format:"Y-m-d"|after_or_equal:dynamizer_start_date_contract|nullable',
            'dynamizer_contract_value_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsDinamizador()) &&
                    request()->dynamizer_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'dynamizer_fees_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsDinamizador()) &&
                    request()->dynamizer_type_relationship == 0
                ) . '|numeric|lte:dynamizer_contract_value_contract|min:0|max:999.999.999|nullable',


        ];
    }

    public function messages()
    {
        return [
            'dynamizer_type_relationship.required'   => 'El campo :attribute  es obligatorio.',
            'regional.required'                 => 'El campo regional es obligatorio.',
            'training_center.required'          => 'El campo centro de formación es obligatorio.',
            'training_program.required'         => 'El campo programa de formación es obligatorio.',
            'training_program.min'              => 'El campo programa de formación debe ser minimo 1 caracter',
            'training_program.max'              => 'El campo programa de formación debe ser máximo 300 caracteres',
            'training_program.regex'            => 'El campo programa de formación debe tener un formato alfanumérico',
            'formation_type.required'           => 'El campo tipo formación es obligatorio.',
            'study_type.required'               => 'El campo tipo estudio es obligatorio.',
            'university.required'               => 'El campo universidad es obligatorio.',
            'university.min'                    => 'El campo universidad debe ser minimo 1 caracter',
            'university.max'                    => 'El campo universidad debe ser máximo 300 caracteres',
            'university.regex'                  => 'El campo universidad debe tener un formato alfanumérico',
            'career.required'                   => 'El campo carrera es obligatorio.',
            'career.min'                        => 'El campo carrera debe ser minimo 1 caracter',
            'career.max'                        => 'El campo carrera debe ser máximo 300 caracteres',
            'career.regex'                      => 'El campo carrera debe tener un formato alfanumérico',
            'company.required'                   => 'El campo empresa es obligatorio.',
            'company.min'                        => 'El campo empresa debe ser minimo 1 caracter',
            'company.max'                        => 'El campo empresa debe ser máximo 300 caracteres',
            'company.regex'                      => 'El campo empresa debe tener un formato alfanumérico',
            'dependency.required'                   => 'El campo dependencia es obligatorio.',
            'dependency.min'                        => 'El campo dependencia debe ser minimo 1 caracter',
            'dependency.max'                        => 'El campo dependencia debe ser máximo 300 caracteres',
            'dependency.regex'                      => 'El campo dependencia debe tener un formato alfanumérico',
        ];
    }

    public function attributes()
    {
        return [
            'dynamizer_node' => 'nodo',
            'dynamizer_type_relationship' => 'tipo vinculación',
        ];
    }
}
