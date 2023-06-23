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
    //  * @return array
     */
    public function rules()
    {
        // dd(request()->value());
        return [
            'role'            => 'required',
            'activator_type_relationship' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsActivador())
                ) . '|in:0,1|nullable',
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
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'activator_fees_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsActivador())
                && request()->activator_type_relationship == 0
            ).'|numeric|min:0|max:999.999.999|nullable',
            'dynamizer_node'        => Rule::requiredIf(
                        collect(request()->role)->contains(User::IsDinamizador())
                    ) . '|nullable',
            'dynamizer_type_relationship'        => Rule::requiredIf(
                    collect(request()->role)->contains(User::IsDinamizador())
                    ) .'|in:0,1|nullable',
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
                collect(request()->role)->contains(User::IsDinamizador())
                && request()->activator_type_relationship == 0
            ).'|numeric|min:0|max:999.999.999|nullable',
            'expert_node'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsExperto())
            ) . '|nullable',
            'expert_line'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsExperto())
            ) . '|nullable',
            'expert_type_relationship'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsExperto())
                ) . '|in:0,1|nullable',
            'expert_code_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsExperto()) &&
                    request()->expert_type_relationship == 0
                ) . '|min:1|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'expert_start_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsExperto()) &&
                    request()->expert_type_relationship == 0
                ) . '|date_format:"Y-m-d"|nullable',
            'expert_end_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsExperto()) &&
                    request()->expert_type_relationship == 0
                ) . '|date_format:"Y-m-d"|after_or_equal:expert_start_date_contract|nullable',
            'expert_contract_value_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsExperto()) &&
                    request()->expert_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'expert_fees_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsExperto()) &&
                    request()->expert_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'articulator_node'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsArticulador())
            ) . '|nullable',
            'articulator_type_relationship'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsArticulador())
                ) . '|in:0,1|nullable',
            'articulator_code_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsArticulador()) &&
                    request()->articulator_type_relationship == 0
                ) . '|min:1|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'articulator_start_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsArticulador()) &&
                    request()->articulator_type_relationship == 0
                ) . '|date_format:"Y-m-d"|nullable',
            'articulator_end_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsArticulador()) &&
                    request()->articulator_type_relationship == 0
                ) . '|date_format:"Y-m-d"|after_or_equal:articulator_start_date_contract|nullable',
            'articulator_contract_value_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsArticulador()) &&
                    request()->articulator_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'articulator_fees_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsArticulador()) &&
                    request()->articulator_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'infocenter_node'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsInfocenter())
            ) . '|nullable',
            'infocenter_type_relationship'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsInfocenter())
                ) . '|in:0,1|nullable',
            'infocenter_code_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsInfocenter()) &&
                    request()->infocenter_type_relationship == 0
                ) . '|min:1|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'infocenter_start_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsInfocenter()) &&
                    request()->infocenter_type_relationship == 0
                ) . '|date_format:"Y-m-d"|nullable',
            'infocenter_end_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsInfocenter()) &&
                    request()->infocenter_type_relationship == 0
                ) . '|date_format:"Y-m-d"|after_or_equal:infocenter_start_date_contract|nullable',
            'infocenter_contract_value_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsInfocenter()) &&
                    request()->infocenter_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'infocenter_fees_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsInfocenter()) &&
                    request()->infocenter_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'technical_support_node'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsApoyoTecnico())
            ) . '|nullable',
            'technical_support_line'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsApoyoTecnico())
            ) . '|nullable',
            'technical_support_type_relationship'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsApoyoTecnico())
                ) . '|nullable',
            'technical_support_code_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsApoyoTecnico()) &&
                    request()->technical_support_type_relationship == 0
                ) . '|min:1|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'technical_support_start_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsApoyoTecnico()) &&
                    request()->technical_support_type_relationship == 0
                ) . '|date_format:"Y-m-d"|nullable',
            'technical_support_end_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsApoyoTecnico()) &&
                    request()->technical_support_type_relationship == 0
                ) . '|date_format:"Y-m-d"|after_or_equal:technical_support_start_date_contract|nullable',
            'technical_support_contract_value_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsApoyoTecnico()) &&
                    request()->technical_support_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'technical_support_fees_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsApoyoTecnico()) &&
                    request()->technical_support_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'income_node'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsIngreso())
            ) . '|nullable',
            'income_type_relationship'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsIngreso())
                ) . '|in:0,1|nullable',
            'income_code_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsIngreso()) &&
                    request()->income_type_relationship == 0
                ) . '|min:1|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'income_start_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsIngreso()) &&
                    request()->income_type_relationship == 0
                ) . '|date_format:"Y-m-d"|nullable',
            'income_end_date_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsIngreso()) &&
                    request()->income_type_relationship == 0
                ) . '|date_format:"Y-m-d"|after_or_equal:income_start_date_contract|nullable',
            'income_contract_value_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsIngreso()) &&
                    request()->income_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',
            'income_fees_contract' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsIngreso()) &&
                    request()->income_type_relationship == 0
                ) . '|numeric|min:0|max:999.999.999|nullable',


            'talent_type'            => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento())
                ) . '|nullable',
            'regional'               => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                (request()->talent_type == 1 ||
                request()->talent_type == 2 ||
                request()->talent_type == 3 ||
                request()->talent_type == 4 ||
                request()->talent_type == 5)
            ) . '|nullable',
            'training_center'        => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                (request()->talent_type == 1 ||
                request()->talent_type == 2 ||
                request()->talent_type == 3 ||
                request()->talent_type == 4 ||
                request()->talent_type == 5)
            ) . '|nullable',
            'training_program' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                (request()->talent_type == 1 ||
                request()->talent_type == 2 ||
                request()->talent_type == 3)
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'formation_type'       => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                (request()->talent_type == 3)
            ) . '|nullable',
            'study_type'  => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                request()->talent_type == 8
            ) . '|nullable',
            'university'  => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                request()->talent_type == 8
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'career'  => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                request()->talent_type == 8
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'company'  => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                (request()->talent_type == 6 ||
                request()->talent_type == 9)
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',
            'dependency' => Rule::requiredIf(
                collect(request()->role)->contains(User::IsTalento()) &&
                request()->talent_type == 5
            ) . '|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|nullable',

        ];
    }

    public function messages()
    {
        return [
            'role.required'                                => 'El campo rol es obligatorio.',
            'activator_type_relationship.required'         => 'El campo tipo vinculación es obligatorio.',
            'activator_code_contract.required'             => 'El campo código es obligatorio.',
            'activator_code_contract.min'                  => 'El campo código debe ser minimo :min caracter(es)',
            'activator_code_contract.max'                  => 'El campo código debe ser máximo :max caracter(es)',
            'activator_code_contract.regex'                => 'El campo código debe tener un formato alfanumérico',
            'activator_start_date_contract.required'       => 'El campo fecha inicio contrato es obligatorio.',
            'activator_start_date_contract.regex'          => 'El campo fecha inicio contrato debe tener un formato alfanumérico',
            'activator_start_date_contract.date_format'    => 'El campo fecha inicio contrato no coincide con el formato :format',
            'activator_end_date_contract.required'         => 'El campo fecha finalización contrato es obligatorio.',
            'activator_end_date_contract.regex'            => 'El campo fecha finalización contrato debe tener un formato alfanumérico',
            'activator_end_date_contract.date_format'      => 'El campo fecha finalización contrato no coincide con el formato :format',
            'activator_end_date_contract.after_or_equal'   => 'El campo fecha finalización contrato debe ser una fecha posterior o igual a :date',
            'activator_contract_value_contract.required'   => 'El campo valor contrato es obligatorio.',
            'activator_contract_value_contract.min'        => 'El campo valor contrato debe ser minimo :min caracter(es)',
            'activator_contract_value_contract.max'        => 'El campo valor contrato debe ser máximo :max caracter(es)',
            'activator_contract_value_contract.numeric'    => 'El campo valor contrato debe ser ser numérico',
            'activator_fees_contract.required'             => 'El campo honorarios es obligatorio.',
            'activator_fees_contract.min'                  => 'El campo honorarios debe ser minimo :min caracter(es)',
            'activator_fees_contract.max'                  => 'El campo honorarios debe ser máximo :max caracter(es)',
            'activator_fees_contract.numeric'              => 'El campo honorarios debe ser ser numérico',
            'activator_fees_contract.lte'              => 'El campo honorarios debe ser menor o igual que :value.',

            'dynamizer_node.required'                      => 'El campo nodo es obligatorio.',
            'dynamizer_type_relationship.required'         => 'El campo tipo vinculación es obligatorio.',
            'dynamizer_code_contract.required'             => 'El campo código es obligatorio.',
            'dynamizer_code_contract.min'                  => 'El campo código debe ser minimo :min caracter(es)',
            'dynamizer_code_contract.max'                  => 'El campo código debe ser máximo :max caracter(es)',
            'dynamizer_code_contract.regex'                => 'El campo código debe tener un formato alfanumérico',
            'dynamizer_start_date_contract.required'       => 'El campo fecha inicio contrato es obligatorio.',
            'dynamizer_start_date_contract.regex'          => 'El campo fecha inicio contrato debe tener un formato alfanumérico',
            'dynamizer_start_date_contract.date_format'    => 'El campo fecha inicio contrato no coincide con el formato :format',
            'dynamizer_end_date_contract.required'         => 'El campo fecha finalización contrato es obligatorio.',
            'dynamizer_end_date_contract.regex'            => 'El campo fecha finalización contrato debe tener un formato alfanumérico',
            'dynamizer_end_date_contract.date_format'      => 'El campo fecha finalización contrato no coincide con el formato :format',
            'dynamizer_end_date_contract.after_or_equal'   => 'El campo fecha finalización contrato debe ser una fecha posterior o igual a :date',
            'dynamizer_contract_value_contract.required'   => 'El campo valor contrato es obligatorio.',
            'dynamizer_contract_value_contract.min'        => 'El campo valor contrato debe ser minimo :min caracter(es)',
            'dynamizer_contract_value_contract.max'        => 'El campo valor contrato debe ser máximo :max caracter(es)',
            'dynamizer_contract_value_contract.numeric'    => 'El campo valor contrato debe ser ser numérico',
            'dynamizer_fees_contract.required'             => 'El campo honorarios es obligatorio.',
            'dynamizer_fees_contract.min'                  => 'El campo honorarios debe ser minimo :min caracter(es)',
            'dynamizer_fees_contract.max'                  => 'El campo honorarios debe ser máximo :max caracter(es)',
            'dynamizer_fees_contract.numeric'              => 'El campo honorarios debe ser ser numérico',
            'dynamizer_fees_contract.lte'              => 'El campo honorarios debe ser menor o igual que :value.',

            'expert_node.required'                      => 'El campo nodo es obligatorio.',
            'expert_line.required'                      => 'El campo línea es obligatorio.',
            'expert_type_relationship.required'         => 'El campo tipo vinculación es obligatorio.',
            'expert_code_contract.required'             => 'El campo código es obligatorio.',
            'expert_code_contract.min'                  => 'El campo código debe ser minimo :min caracter(es)',
            'expert_code_contract.max'                  => 'El campo código debe ser máximo :max caracter(es)',
            'expert_code_contract.regex'                => 'El campo código debe tener un formato alfanumérico',
            'expert_start_date_contract.required'       => 'El campo fecha inicio contrato es obligatorio.',
            'expert_start_date_contract.regex'          => 'El campo fecha inicio contrato debe tener un formato alfanumérico',
            'expert_start_date_contract.date_format'    => 'El campo fecha inicio contrato no coincide con el formato :format',
            'expert_end_date_contract.required'         => 'El campo fecha finalización contrato es obligatorio.',
            'expert_end_date_contract.regex'            => 'El campo fecha finalización contrato debe tener un formato alfanumérico',
            'expert_end_date_contract.date_format'      => 'El campo fecha finalización contrato no coincide con el formato :format',
            'expert_end_date_contract.after_or_equal'   => 'El campo fecha finalización contrato debe ser una fecha posterior o igual a :date',
            'expert_contract_value_contract.required'   => 'El campo valor contrato es obligatorio.',
            'expert_contract_value_contract.min'        => 'El campo valor contrato debe ser minimo :min caracter(es)',
            'expert_contract_value_contract.max'        => 'El campo valor contrato debe ser máximo :max caracter(es)',
            'expert_contract_value_contract.numeric'    => 'El campo valor contrato debe ser ser numérico',
            'expert_fees_contract.required'             => 'El campo honorarios es obligatorio.',
            'expert_fees_contract.min'                  => 'El campo honorarios debe ser minimo :min caracter(es)',
            'expert_fees_contract.max'                  => 'El campo honorarios debe ser máximo :max caracter(es)',
            'expert_fees_contract.numeric'              => 'El campo honorarios debe ser ser numérico',
            'expert_fees_contract.lte'              => 'El campo honorarios debe ser menor o igual que :value.',



            'articulator_node.required'                      => 'El campo nodo es obligatorio.',
            'articulator_type_relationship.required'         => 'El campo tipo vinculación es obligatorio.',
            'articulator_code_contract.required'             => 'El campo código es obligatorio.',
            'articulator_code_contract.min'                  => 'El campo código debe ser minimo :min caracter(es)',
            'articulator_code_contract.max'                  => 'El campo código debe ser máximo :max caracter(es)',
            'articulator_code_contract.regex'                => 'El campo código debe tener un formato alfanumérico',
            'articulator_start_date_contract.required'       => 'El campo fecha inicio contrato es obligatorio.',
            'articulator_start_date_contract.regex'          => 'El campo fecha inicio contrato debe tener un formato alfanumérico',
            'articulator_start_date_contract.date_format'    => 'El campo fecha inicio contrato no coincide con el formato :format',
            'articulator_end_date_contract.required'         => 'El campo fecha finalización contrato es obligatorio.',
            'articulator_end_date_contract.regex'            => 'El campo fecha finalización contrato debe tener un formato alfanumérico',
            'articulator_end_date_contract.date_format'      => 'El campo fecha finalización contrato no coincide con el formato :format',
            'articulator_end_date_contract.after_or_equal'   => 'El campo fecha finalización contrato debe ser una fecha posterior o igual a :date',
            'articulator_contract_value_contract.required'   => 'El campo valor contrato es obligatorio.',
            'articulator_contract_value_contract.min'        => 'El campo valor contrato debe ser minimo :min caracter(es)',
            'articulator_contract_value_contract.max'        => 'El campo valor contrato debe ser máximo :max caracter(es)',
            'articulator_contract_value_contract.numeric'    => 'El campo valor contrato debe ser ser numérico',
            'articulator_fees_contract.required'             => 'El campo honorarios es obligatorio.',
            'articulator_fees_contract.min'                  => 'El campo honorarios debe ser minimo :min caracter(es)',
            'articulator_fees_contract.max'                  => 'El campo honorarios debe ser máximo :max caracter(es)',
            'articulator_fees_contract.numeric'              => 'El campo honorarios debe ser ser numérico',
            'articulator_fees_contract.lte'              => 'El campo honorarios debe ser menor o igual que :value.',

            'infocenter_node.required'                      => 'El campo nodo es obligatorio.',
            'infocenter_type_relationship.required'         => 'El campo tipo vinculación es obligatorio.',
            'infocenter_code_contract.required'             => 'El campo código es obligatorio.',
            'infocenter_code_contract.min'                  => 'El campo código debe ser minimo :min caracter(es)',
            'infocenter_code_contract.max'                  => 'El campo código debe ser máximo :max caracter(es)',
            'infocenter_code_contract.regex'                => 'El campo código debe tener un formato alfanumérico',
            'infocenter_start_date_contract.required'       => 'El campo fecha inicio contrato es obligatorio.',
            'infocenter_start_date_contract.regex'          => 'El campo fecha inicio contrato debe tener un formato alfanumérico',
            'infocenter_start_date_contract.date_format'    => 'El campo fecha inicio contrato no coincide con el formato :format',
            'infocenter_end_date_contract.required'         => 'El campo fecha finalización contrato es obligatorio.',
            'infocenter_end_date_contract.regex'            => 'El campo fecha finalización contrato debe tener un formato alfanumérico',
            'infocenter_end_date_contract.date_format'      => 'El campo fecha finalización contrato no coincide con el formato :format',
            'infocenter_end_date_contract.after_or_equal'   => 'El campo fecha finalización contrato debe ser una fecha posterior o igual a :date',
            'infocenter_contract_value_contract.required'   => 'El campo valor contrato es obligatorio.',
            'infocenter_contract_value_contract.min'        => 'El campo valor contrato debe ser minimo :min caracter(es)',
            'infocenter_contract_value_contract.max'        => 'El campo valor contrato debe ser máximo :max caracter(es)',
            'infocenter_contract_value_contract.numeric'    => 'El campo valor contrato debe ser ser numérico',
            'infocenter_fees_contract.required'             => 'El campo honorarios es obligatorio.',
            'infocenter_fees_contract.min'                  => 'El campo honorarios debe ser minimo :min caracter(es)',
            'infocenter_fees_contract.max'                  => 'El campo honorarios debe ser máximo :max caracter(es)',
            'infocenter_fees_contract.numeric'              => 'El campo honorarios debe ser ser numérico',
            'infocenter_fees_contract.lte'              => 'El campo honorarios debe ser menor o igual que :value.',

            'technical_support_node.required'                      => 'El campo nodo es obligatorio.',
            'technical_support_line.required'                      => 'El campo línea es obligatorio.',
            'technical_support_type_relationship.required'         => 'El campo tipo vinculación es obligatorio.',
            'technical_support_code_contract.required'             => 'El campo código es obligatorio.',
            'technical_support_code_contract.min'                  => 'El campo código debe ser minimo :min caracter(es)',
            'technical_support_code_contract.max'                  => 'El campo código debe ser máximo :max caracter(es)',
            'technical_support_code_contract.regex'                => 'El campo código debe tener un formato alfanumérico',
            'technical_support_start_date_contract.required'       => 'El campo fecha inicio contrato es obligatorio.',
            'technical_support_start_date_contract.regex'          => 'El campo fecha inicio contrato debe tener un formato alfanumérico',
            'technical_support_start_date_contract.date_format'    => 'El campo fecha inicio contrato no coincide con el formato :format',
            'technical_support_end_date_contract.required'         => 'El campo fecha finalización contrato es obligatorio.',
            'technical_support_end_date_contract.regex'            => 'El campo fecha finalización contrato debe tener un formato alfanumérico',
            'technical_support_end_date_contract.date_format'      => 'El campo fecha finalización contrato no coincide con el formato :format',
            'technical_support_end_date_contract.after_or_equal'   => 'El campo fecha finalización contrato debe ser una fecha posterior o igual a :date',
            'technical_support_contract_value_contract.required'   => 'El campo valor contrato es obligatorio.',
            'technical_support_contract_value_contract.min'        => 'El campo valor contrato debe ser minimo :min caracter(es)',
            'technical_support_contract_value_contract.max'        => 'El campo valor contrato debe ser máximo :max caracter(es)',
            'technical_support_contract_value_contract.numeric'    => 'El campo valor contrato debe ser ser numérico',
            'technical_support_fees_contract.required'             => 'El campo honorarios es obligatorio.',
            'technical_support_fees_contract.min'                  => 'El campo honorarios debe ser minimo :min caracter(es)',
            'technical_support_fees_contract.max'                  => 'El campo honorarios debe ser máximo :max caracter(es)',
            'technical_support_fees_contract.numeric'              => 'El campo honorarios debe ser ser numérico',
            'technical_support_fees_contract.lte'              => 'El campo honorarios debe ser menor o igual que :value.',

            'income_node.required'                      => 'El campo nodo es obligatorio.',
            'income_type_relationship.required'         => 'El campo tipo vinculación es obligatorio.',
            'income_code_contract.required'             => 'El campo código es obligatorio.',
            'income_code_contract.min'                  => 'El campo código debe ser minimo :min caracter(es)',
            'income_code_contract.max'                  => 'El campo código debe ser máximo :max caracter(es)',
            'income_code_contract.regex'                => 'El campo código debe tener un formato alfanumérico',
            'income_start_date_contract.required'       => 'El campo fecha inicio contrato es obligatorio.',
            'income_start_date_contract.regex'          => 'El campo fecha inicio contrato debe tener un formato alfanumérico',
            'income_start_date_contract.date_format'    => 'El campo fecha inicio contrato no coincide con el formato :format',
            'income_end_date_contract.required'         => 'El campo fecha finalización contrato es obligatorio.',
            'income_end_date_contract.regex'            => 'El campo fecha finalización contrato debe tener un formato alfanumérico',
            'income_end_date_contract.date_format'      => 'El campo fecha finalización contrato no coincide con el formato :format',
            'income_end_date_contract.after_or_equal'   => 'El campo fecha finalización contrato debe ser una fecha posterior o igual a :date',
            'income_contract_value_contract.required'   => 'El campo valor contrato es obligatorio.',
            'income_contract_value_contract.min'        => 'El campo valor contrato debe ser minimo :min caracter(es)',
            'income_contract_value_contract.max'        => 'El campo valor contrato debe ser máximo :max caracter(es)',
            'income_contract_value_contract.numeric'    => 'El campo valor contrato debe ser ser numérico',
            'income_fees_contract.required'             => 'El campo honorarios es obligatorio.',
            'income_fees_contract.min'                  => 'El campo honorarios debe ser minimo :min caracter(es)',
            'income_fees_contract.max'                  => 'El campo honorarios debe ser máximo :max caracter(es)',
            'income_fees_contract.numeric'              => 'El campo honorarios debe ser ser numérico',
            'income_fees_contract.lte'              => 'El campo honorarios debe ser menor o igual que :value.',

            'talent_type.required'              => 'El campo tipo talento es obligatorio.',
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
