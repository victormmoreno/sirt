<?php

namespace App\Http\Requests\Accompaniment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccompanimentRequests extends FormRequest
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
            'accompaniment_type' => 'required|'. Rule::in(['pbt', 'empresa']),
            'name_accompaniment' => 'required|min:1|max:100',
            'description_accompaniment'  => 'required|min:1|max:3000',
            'scope_accompaniment'  => 'required|min:1|max:3000',
            'projects'  => Rule::requiredIf(request()->accompaniment_type == 'pbt'),
            'talent'  => Rule::requiredIf(request()->accompaniment_type == 'pbt'),
            'sedes'  => Rule::requiredIf(request()->accompaniment_type == 'empresa'),
            'confidency_format'  => 'required|file|max:50000|mimetypes:application/pdf|mimes:pdf',
        ];
    }

    public function messages()
    {
        return $messages = [];
    }

    /**
 * Get custom attributes for validator errors.
 *
 * @return array
 */
public function attributes()
{
    return [
        'accompaniment_type' => 'tipo acompañamiento',
        'sedes' => 'sede',
        'confidency_format' => 'formato de confidencialidad',
    ];
}
}
