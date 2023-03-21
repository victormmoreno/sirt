<?php

namespace App\Http\Requests\Articulation;

use App\Models\ArticulationStage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticulationStageRequest extends FormRequest
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
                'name' => 'required|min:1|max:600',
                'node' => Rule::requiredIf(function (){
                    return (bool) request()->user()->can('listNodes', ArticulationStage::class);
                }) ,
                'description'  => 'required|min:1|max:3000',
                'expected_results'  => 'required|min:1|max:3000',
                'scope'  => 'required|min:1|max:3000',
                'projects'  => 'required',
                'talent'  => 'required'
            ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'El campo nombre es obligatorio.',
            'name.min'          => 'El campo nombre debe ser de al menos :min caracter.',
            'name.max'          => 'El campo nombre no debe ser mayor a :max caracter(es)',
            'description.required'     => 'El campo descripción es obligatorio.',
            'description.min'          => 'El campo descripción debe ser de al menos :min caracter.',
            'description.max'   => 'El campo descripción no debe ser mayor a :max caracter(es)',
            'scope.required'     => 'El campo alcance es obligatorio.',
            'expected_results.required'     => 'El campo '. __('Expected Results').' es obligatorio.',
            'expected_results.min'          => 'El campo '. __('Expected Results').' debe ser de al menos :min caracter.',
            'expected_results.max'   => 'El campo '. __('Expected Results').' no debe ser mayor a :max caracter(es)',
            'scope.required'     => 'El campo alcance es obligatorio.',
            'scope.min'          => 'El campo alcance debe ser de al menos :min caracter.',
            'scope.max'          => 'El campo alcance no debe ser mayor a :max caracter(es)',
            'projects.required'  => 'Selecciona por lo menos un proyecto',
            'node.required'  => 'El campo nodo es obligatorio',
            'talent.required'  => 'Selecciona por lo menos un talento',
        ];
    }
}
