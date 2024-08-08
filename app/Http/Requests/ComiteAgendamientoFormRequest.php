<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;  // Asegúrate de que la ruta al modelo User sea correcta

class ComiteAgendamientoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Cambiar a true para permitir la autorización
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
            'txtfechacomite_create' => 'required|date_format:Y-m-d',
            'ideas' => 'required',
            'gestores' => 'required|array',
            'gestores.*.id' => 'required|exists:users,id',
            'gestores.*.hora_inicio' => 'required',
            'gestores.*.hora_fin' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'txtfechacomite_create.required' => 'La Fecha del Comité es obligatoria.',
            'txtfechacomite_create.date_format' => 'La Fecha del Comité no tiene un formato válido. El formato debe ser Año-Mes-Día (Y-m-d).',

            'ideas.required' => 'Se requiere por lo menos una idea de proyecto.',

            'gestores.required' => 'Se requiere por lo menos un experto.',
            'gestores.*.id.required' => 'El campo ID del experto es obligatorio.',
            'gestores.*.id.exists' => 'El experto seleccionado no existe en la base de datos.',
            'gestores.*.hora_inicio.required' => 'La hora de inicio es obligatoria para cada experto.',
            'gestores.*.hora_fin.required' => 'La hora de fin es obligatoria para cada experto.',
        ];

        if ($this->request->has('gestores')) {
            foreach ($this->request->get('gestores') as $key => $value) {
                $gestor = User::find($value['id']);
                if ($gestor) {
                    $messages['gestores.' . $key . '.hora_inicio.required'] = 'La hora de inicio del experto ' . $gestor->nombre . ' es obligatoria.';
                    $messages['gestores.' . $key . '.hora_fin.required'] = 'La hora de fin del experto ' . $gestor->nombre . ' es obligatoria.';
                }
            }
        }

        return $messages;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'txtfechacomite_create' => 'Fecha del Comité',
        ];
    }
}
