<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaFormRequest extends FormRequest
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
    public function rules($sit = null)
    {
        return [
            'txtnit_empresa' => Rule::requiredIf($sit != 'just_hq').'|digits_between:8,13|unique:empresas,nit,' . request()->route('id'),
            'txtcodigo_ciiu_empresa' => 'max:15|nullable',
            'txtnombre_empresa' => Rule::requiredIf($sit != 'just_hq') . '|min:1|max:300',
            'txtnombre_sede' =>  Rule::requiredIf($sit != 'just_comp') . '|min:1|max:300',
            'txtfecha_creacion_empresa' => 'date_format:Y-m-d|nullable',
            'txtsector_empresa' => Rule::requiredIf($sit != 'just_hq'),
            'txtemail_entidad' => 'email|nullable|min:7|max:200',
            'txtdireccion_sede' => 'max:100|nullable',
            'txtdepartamento_sede' => Rule::requiredIf($sit != 'just_comp'),
            'txtciudad_id_sede' => Rule::requiredIf($sit != 'just_comp'),
            'txttamanhoempresa_id_empresa' => Rule::requiredIf($sit != 'just_hq'),
            'txttipoempresa_id_empresa' => Rule::requiredIf($sit != 'just_hq'),
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtnombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'txtnombre_empresa.min' => 'El nombre de la empresa debe ser mínimo de 1 caracter.',
            'txtnombre_empresa.max' => 'El nombre de la empresa debe ser máximo de 300 caracteres.',
            'txtnombre_empresa.regex' => 'El formate del campo nombre de la empresa es incorrecto.',
            'txtnombre_sede.required' => 'El nombre de la sede es obligatorio.',
            'txtnombre_sede.min' => 'El nombre de la sede debe ser mínimo de 1 caracter.',
            'txtnombre_sede.max' => 'El nombre de la sede debe ser máximo de 300 caracteres.',
            'txtnombre_sede.regex' => 'El formate del campo nombre de la sede es incorrecto.',
            'txtnit_empresa.required' => 'El nit de la empresa es obligatorio.',
            'txtnit_empresa.numeric' => 'El nit de la empresa debe ser numérico (Sin puntos ni número de verificación).',
            'txtnit_empresa.unique' => 'El nit de la empresa ya se encuentra registrado.',
            'txtnit_empresa.digits_between' => 'El nit de la empresa debe tener entre 8 y 13 dígitos.',
            'txtemail_entidad.email' => 'El formato del email de la empresa es incorrecto.',
            'txtemail_entidad.min' => 'El email de la empresa debe ser mínimo de 7 caracteres.',
            'txtemail_entidad.max' => 'El email de la empresa debe ser máximo de 200 caracteres.',
            'txtdireccion_sede.max' => 'La dirección de la empresa deben ser máximo de 100 caracteres.',
            'txtdepartamento_sede.required' => 'El departamento de la Empresa es obligatorio.',
            'txtciudad_id_sede.required' => 'La ciudad de la empresa es obligatoria.',
            'txtsector_empresa.required' => 'El sector de la empresa es obligatorio.',
            'txttamanhoempresa_id_empresa.required' => 'El tamaño de la empresa es obligatorio.',
            'txttipoempresa_id_empresa.required' => 'El tipo de la empresa es obligatorio.',
            'txtfecha_creacion_empresa.date_format' => 'La fecha de creación no tiene un formato válido (Y-m-d).',
            'txtcodigo_ciiu_empresa.max' => 'El código CIIU de la empresa debe ser máximo de 15 carácteres.',
        ];
    }
}
