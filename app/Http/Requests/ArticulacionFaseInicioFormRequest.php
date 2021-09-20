<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticulacionFaseInicioFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'txtgrupo_id' => 'required',
            'txtnombre' => 'required|max:500',
            'talentos' => 'required',
            'radioTalentoLider' => 'required',
            'productos' => 'required',
            'txtacuerdos' => 'required|max:1000',
            'txtalcance_articulacion' => 'required|max:1000'
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtgrupo_id.required' => 'El Grupo de Investigación es obligatorio.',

            'txtnombre.required' => 'El Nombre de la Articulación es obligatorio.',
            'txtnombre.max' => 'El Nombre de la Articulación debe ser máximo 500 carácteres.',

            'talentos.required' => 'Debe asociar por lo menos un talento al proyecto.',

            'radioTalentoLider.required' => 'El talento interlocutor de la articulación es obligatorio.',

            'productos.required' => 'Se debe elegir uno o más productos a alcanzar.',

            'txtacuerdos.required' => 'El acuerdo de coautoría de la articulación es obligatorio.',
            'txtacuerdos.max' => 'El acuerdo de coautoría de la articulación debe ser máximo de 1000 carácteres.',

            'txtalcance_articulacion.required' => 'El alcance de la articulación es obligatorio.',
            'txtalcance_articulacion.max' => 'El alcance de la articulación debe ser máximo de 1000 carácteres.',
        ];
    }
}
