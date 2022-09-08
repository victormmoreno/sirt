<?php

namespace App\Http\Requests\Articulation;

use Illuminate\Foundation\Http\FormRequest;

class ArticulationSubtypeRequest extends FormRequest
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
            'articulationtype' => 'required',
            'name' => 'required|min:1|max:500|unique:articulation_subtypes,name,' . request()->route('tiposubarticulacione'),
            'description' => 'nullable|min:1|max:5000',
            'entity' => 'required|min:1|max:1000',
            'checknode' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'    => 'El campo nombre es obligatorio.',
            'name.min'         => 'El nombre debe ser de al menos :min caracter.',
            'name.max'         => 'El nombre no debe ser mayor a :max caracter(es)',
            'name.unique'      => 'El nombre ya ha sido registrado',
            'description.min'    => 'La descripción debe ser de al menos :min caracter.',
            'description.max'    => 'La descripción no debe ser mayor a :max caracter(es)',
            'entity.required' => 'El campo entidades es obligatorio.',
            'entity.min'         => 'El campo entidades debe ser de al menos :min caracter.',
            'checknode.required'         => 'El campo nodo es obligatorio',
            'articulationtype.required'         => 'El campo tipo articulación es obligatorio.',
        ];
    }
}
