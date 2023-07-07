<?php

namespace App\Http\Requests\UsersRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserSearchRequest extends FormRequest
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
            'txttype_search' => ['required', Rule::in(['1', '2'])],
            'txtsearch_user' => Rule::requiredIf(
                isset(request()->txttype_search) && request()->txttype_search == 1 ? 'required|digits_between:6,11|numeric' : 'required|email'
            ),
        ];
    }
}
