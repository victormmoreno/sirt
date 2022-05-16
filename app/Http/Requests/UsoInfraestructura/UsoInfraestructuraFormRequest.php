<?php

namespace App\Http\Requests\UsoInfraestructura;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UsoInfraestructuraFormRequest extends FormRequest
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
        if (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {

            return [
                'txtfecha'                  => 'required|date_format:"Y-m-d"',
                'txtlinea'                  => 'required',
                'asesoriadirecta'           => 'required|array',
                'asesoriaindirecta'         => 'required|array',

                'txttipousoinfraestructura' => 'required',
                'txtactividad'              => 'required',
                'txtcompromisos'            => 'required|max:2400',
                'txtdescripcion'            => 'nullable|max:2000',
                'txtasesoriadirecta'        => 'nullable|numeric|min:0|max:99|between:0,99.9',
                'txtasesoriaindirecta'      => 'nullable|numeric|min:0|max:99|between:0,99.9',

                'txttiempouso'              => 'nullable|numeric|min:0|max:99|between:0,99.9',
                'txtcantidad'               => 'nullable|numeric|min:0|max:99|between:0,99.9',

            ];
        }
        elseif (session()->has('login_role') && session()->get('login_role') == User::IsArticulador()) {

            return [
                'txtfecha'                  => 'required|date_format:"Y-m-d"',
                'asesoriadirecta'           => 'required|array',
                'asesoriaindirecta'         => 'required|array',

                'txttipousoinfraestructura' => 'required',
                'txtactividad'              => 'required',
                'txtcompromisos'            => 'required|max:2400',
                'txtdescripcion'            => 'nullable|max:2000',
                'txtasesoriadirecta'        => 'nullable|numeric|min:0|max:99|between:0,99.9',
                'txtasesoriaindirecta'      => 'nullable|numeric|min:0|max:99|between:0,99.9',

                'txttiempouso'              => 'nullable|numeric|min:0|max:99|between:0,99.9',
                'txtcantidad'               => 'nullable|numeric|min:0|max:99|between:0,99.9',

            ];
        } else if (session()->has('login_role') && session()->get('login_role') == User::IsTalento()) {
            return [
                'txtfecha'                  => 'required|date_format:"Y-m-d"',
                'txtlinea'                  => 'required',
                'txttipousoinfraestructura' => 'required',
                'txtactividad'              => 'required',
                'txtdescripcion'            => 'nullable|max:2000',
                'txtcompromisos'            => 'required|max:2400',
                'txttiempouso'              => 'nullable|numeric|min:0|max:99|between:0,99.9',
                'txtcantidad'               => 'nullable|numeric|min:0|max:99|between:0,99.9',
            ];
        } else {
            return ['no tienes permisos'];
        }
    }

    public function messages()
    {
        return $messages = [
            'txtfecha.required'                  => 'La fecha es obligatoria',
            'txtfecha.date_format'               => 'La fecha debe tener un formato de Y-m-d',
            'txtlinea.required'                  => 'La linea tecnológica es obligatoria',
            'txtgestor.required'                 => 'El experto es obligatorio',
            'txttipousoinfraestructura.required' => 'por favor seleccione el tipo de uso de infraestructura',
            'txtactividad.required'              => 'El proyecto ó la articulación es obligatoria',
            'txtdescripcion.max'                 => 'La descripcion debe tener máximo 2000 caracteres',
            'txtcompromisos.max'                 => 'El próximo compromiso debe tener máximo 2400 caracteres',
            'txtcompromisos.required'                 => 'El próximo compromiso es obligatorio',
            'txtasesoriadirecta.numeric'         => 'La asesoria directa debe ser un valor numérico',
            'txtasesoriadirecta.min'             => 'La asesoria directa debe ser un valor numérico igual o mayor a 0.',
            'txtasesoriadirecta.max'             => 'La asesoria directa debe ser un valor numérico igual o menor a 99.',
            'txtasesoriadirecta.between'         => 'La asesoria directa debe ser un valor numérico 0 y 99.9',
            'txtasesoriaindirecta.numeric'       => 'La asesoria directa debe ser un valor numérico',
            'txtasesoriaindirecta.min'           => 'La asesoria directa debe ser un valor numérico igual o mayor a 0.',
            'txtasesoriaindirecta.max'           => 'La asesoria directa debe ser un valor numérico igual o menor a 99.',
            'txtasesoriaindirecta.between'       => 'La asesoria directa debe ser un valor numérico entre 0 y 99.9',

            'txttiempouso.numeric'               => 'El tiempo de uso debe ser un valor numérico',
            'txttiempouso.min'                   => 'El tiempo de uso debe ser un valor numérico igual o mayor a 0.',
            'txttiempouso.max'                   => 'El tiempo de uso debe ser un valor numérico igual o menor a 99.',
            'txttiempouso.between'               => 'El tiempo de uso debe ser un valor numérico 0 y 99.9',

            'txtcantidad.numeric'                => 'La cantidad debe ser un valor numérico',
            'txtcantidad.min'                    => 'La cantidad debe ser un valor numérico igual o mayor a 0.',
            'txtcantidad.max'                    => 'La cantidad debe ser un valor numérico igual o menor a 99.',
            'txtcantidad.between'                => 'La cantidad debe ser un valor numérico 0 y 99.9',

            'asesoriadirecta.required'           => 'La asesoria directa es obligatoria.',
            'asesoriaindirecta.required'         => 'La asesoria indirecta es obligatoria.',
        ];
    }
}
