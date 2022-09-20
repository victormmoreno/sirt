<?php

namespace App\Http\Requests\Articulation;

use App\Models\ArticulationStage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;

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
                'name' => 'required|min:1|max:100',
                'node' => Rule::requiredIf(function (){
                    return (bool) request()->user()->can('listNodes', ArticulationStage::class);
                }) ,
                'description'  => 'max:3000',
                'scope'  => 'required|min:1|max:3000',
                'projects'  => 'required',
                'talent'  => 'required',
                'confidency_format'  => 'required|file|max:50000|mimetypes:application/pdf|mimes:pdf',
            ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'El nombre es obligatorio.',
            'name.min'          => 'El nombre debe ser de al menos :min caracter.',
            'name.max'          => 'El nombre no debe ser mayor a :max caracter(es)',
            'description.max'   => 'La descripción no debe ser mayor a :max caracter(es)',
            'scope.required'     => 'El alcance es obligatorio.',
            'scope.min'          => 'El alcance debe ser de al menos :min caracter.',
            'scope.max'          => 'El alcance no debe ser mayor a :max caracter(es)',
            'projects.required'  => 'Selecciona por lo menos un proyecto',
            'node.required'  => 'El campo nodo es obligatorio',
            'talent.required'  => 'Selecciona por lo menos un talento',
            'confidency_format.required'     => 'El formato de confidencialidad es obligatorio.',
            'confidency_format.min'          => 'El formato de confidencialidad debe ser de un archivo',
            'confidency_format.max'          => 'El formato de confidencialidad no debe ser mayor a :max caracter(es)',
        ];
    }
}
