<?php

namespace App\Http\Requests\Articulation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticulationRequest extends FormRequest
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
            'articulation_type' => 'required',
            'articulation_subtype' => 'required',
            'name_articulation' => 'required|min:1|max:600',
            'description_articulation'  => 'max:3000',
            'talents'  => 'required'
        ];
    }

    public function messages()
    {
        return $messages = [];
    }
}
