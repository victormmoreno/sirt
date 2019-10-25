<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Articulacion;
use Illuminate\Validation\Rule;

class ArticulacionFormRequest extends FormRequest
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
    // dd(request()->group1);
    return [
      'group1' => 'required',
      'txtgrupo_id' => Rule::requiredIf(request()->group1 == Articulacion::IsGrupo()),
      'txtempresa_id' => Rule::requiredIf(request()->group1 == Articulacion::IsEmpresa()),
      'documento.*' => Rule::requiredIf(request()->group1 == Articulacion::IsEmprendedor()) . '|numeric|digits_between:6,11',
      // 'radioTalentoLider' => Rule::requiredIf(request()->group1 == Articulacion::IsEmprendedor()),
      'txtnombre' => 'required|min:4|max:200',
      'txttipoarticulacion_id' => 'required',
      'txtestado' => 'required',
      'txtfecha_inicio' => 'required|date_format:"Y-m-d"',
      'txtfecha_cierre' => Rule::requiredIf(request()->txtestado == Articulacion::IsCierre()) . '|date_format:"Y-m-d"|nullable',
      'txtobservaciones' => 'max:1000',
    ];
  }

  public function messages()
  {
    return $messages = [
      'group1.required' => 'El Tipo de Articulación es obligatorio.',

      'txtgrupo_id.required' => 'El Grupo de Investigación es obligatorio.',

      'txtempresa_id.required' => 'La Empresa es obligatoria.',

      'documento.required' => 'Debe haber por lo menos un emprendedor en la articulación.',
      'documento.*.numeric' => 'El número de documente debe ser numérico.',
      'documento.*.digits_between' => 'La cantidad de carácteres del número de documento debe ser entre 6 y 11.',

      // 'radioTalentoLider.required' => 'Se debe elegir un Talento Líder.',

      'txtnombre.required' => 'El Nombre de la Articulación es obligatorio.',
      'txtnombre.max' => 'El Nombre de la Articulación debe ser máximo 1000 caracteres.',
      'txtnombre.min' => 'El Nombre de la Articulación debe ser mínimo 4 caracteres.',

      'txttipoarticulacion_id.required' => 'El tipo de articulación debe ser obligatoria.',

      'txtestado.required' => 'El Estado de la Articulación debe ser obligatorio.',

      'txtfecha_inicio.required' => 'La Fecha de Inicio de la Articulación no tiene un formato válido.',
      'txtfecha_inicio.date_format' => 'La Fecha de Inicio de la Articulación no tiene un formato válido.',

      'txtfecha_cierre.required' => 'La Fecha de Cierre de la Articulación no tiene un formato válido.',
      'txtfecha_cierre.date_format' => 'La Fecha de Cierre de la Articulación no tiene un formato válido.',

      'txtobservaciones.max' => 'Las Observaciones de la Articulación debe ser máximo 1000 caracteres',
      ];
    }

    // Este método no está funcionando
    public function attributes()
    {
      return [
      'group1' => 'Tipo de Articulación',
      'txtgrupo_id' => 'Grupo de Investigación',
      'txtempresa_id' => 'Empresa',
      // 'documento' => 'Talento',
      // 'radioTalentoLider' => 'Talento Líder',
      'txtnombre' => 'Nombre de la Articulación',
      'txttipoarticulacion_id' => 'Actividad',
      'txtestado' => 'Estado de la Articulación',
      'txtfecha_inicio' => 'Fecha de Inicio de la Articulación',
      'txtfecha_cierre' => 'Fecha de Cierre de la Articulación',
      'txtobservaciones' => 'Observaciones de la Articulación',
      ];
    }
  }
