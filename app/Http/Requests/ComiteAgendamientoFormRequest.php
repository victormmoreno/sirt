<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Gestor;

class ComiteAgendamientoFormRequest extends FormRequest
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
        'txtfechacomite_create' => 'required|date_format:"Y-m-d"',
        'ideas' => 'required',
        'horas_inicio.*' => 'required',
        'horas_fin.*' => 'required',
        'gestores' => 'required',
      ];
    }

    public function messages()
    {
      $messages = [
        'txtfechacomite_create.required' => 'La Fecha del Comité es obligatoria.',
        'txtfechacomite_create.date_format' => 'La Fecha del Comité no tiene un formato válido.',
        // 'horas_inicio.*.required' => 'La hora de inicio del experto :value no tiene un formato válido.',

        'ideas.required' => 'Se requiere por lo menos de una idea de proyecto',
        
        'gestores.required' => 'Se requiere por lo menos de un experto',
      ];
      if (request()->get('gestores') !== null) {
        foreach (request()->get('horas_inicio') as $key => $val) {
          $gestor = Gestor::find(request()->gestores[$key]);
          $messages['horas_inicio.'.$key.'.required'] =  'La hora de inicio del experto '. $gestor->user->nombres . ' ' . $gestor->user->apellidos . ' es obligatoria.';
        }
        foreach (request()->get('horas_fin') as $key => $val) {
          $gestor = Gestor::find(request()->gestores[$key]);
          $messages['horas_fin.'.$key.'.required'] =  'La hora de fin del experto '. $gestor->user->nombres . ' ' . $gestor->user->apellidos . ' es obligatoria.';
        }
      }
      return $messages;
    }

    public function attributes()
    {
      return [
        'txtfechacomite_create' => 'Fecha del Comité',
      ];
    }
}
