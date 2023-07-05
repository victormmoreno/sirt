<?php

namespace App\Http\Requests\Asesorie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AsesorieSearchRequest extends FormRequest
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
            'type_search' => ['required', Rule::in(['code_asesorie', 'model_asesorie'])],
            'search_asesorie' => Rule::requiredIf(
                isset(request()->type_search) && request()->type_search == 'code_asesorie' ? 'required' : 'required'
            ),
        ];
    }
}
