<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\ArticulationType;

class ArticulationTypeRequest extends FormRequest
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
            'name' => 'required|min:1|max:100|unique:articulation_types,name,' . request()->route('tipoarticulacione'),
            'description' => 'nullable|min:1|max:5000',
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
        ];
    }
}
