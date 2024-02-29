<?php

namespace App\Http\Requests;

use App\Models\AreaConocimiento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProyectoFaseInicioFormRequest extends FormRequest
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
            'txtidea_id' => 'required',
            'txtnombre' => 'required|min:4|max:200',
            'txtareaconocimiento_id' => 'required',
            'txtotro_areaconocimiento' => Rule::requiredIf(request()->txtareaconocimiento_id == AreaConocimiento::where('nombre', 'Otro')->first()->id) . '|max:100',
            'txtsublinea_id' => 'required',
            'txttipo_economianaranja' => Rule::requiredIf(isset(request()->txteconomia_naranja)) . '|max:100',
            'txttipo_discapacitados' => Rule::requiredIf(isset(request()->txtdirigido_discapacitados)) . '|max:100',
            'txtnom_act_cti' => Rule::requiredIf(isset(request()->txtarti_cti)) . '|max:100',
            'tags' => 'required',
            'talentos' => 'required',
            'radioTalentoLider' => 'required',
            'txtobjetivo' => 'required|max:500',
            'txtalcance_proyecto' => 'required|max:1000',
            'txtobjetivo_especifico1' => 'required|max:500',
            'txtobjetivo_especifico2' => 'required|max:500',
            'txtobjetivo_especifico3' => 'required|max:500',
            'txtobjetivo_especifico4' => 'required|max:500',
            'propietarios_user' => Rule::requiredIf(!isset(request()->propietarios_sedes) && !isset(request()->propietarios_grupos)),
            'propietarios_sedes' => Rule::requiredIf(!isset(request()->propietarios_user) && !isset(request()->propietarios_grupos)),
            'propietarios_grupos' => Rule::requiredIf(!isset(request()->propietarios_sedes) && !isset(request()->propietarios_user)),
        ];
    }

    public function rulesTalentos()
    {
        return [
            'talentos' => 'required',
            'radioTalentoLider' => 'required',
        ];
    }

    public function messages()
    {
        return $messages = [
            // Mensajes para el input txtidea_id
            'txtidea_id.required' => 'La idea de proyecto es obligatoria.',
            // Mensajes para el input txtnombre
            'txtnombre.required' => 'El Nombre del Proyecto es obligatorio.',
            'txtnombre.min' => 'El Nombre del Proyecto debe ser mínimo 4 carácteres.',
            'txtnombre.max' => 'El Nombre del Proyecto debe ser máximo 200 carácteres.',
            // Mensajes para el input txtareaconocimiento_id
            'txtareaconocimiento_id.required' => 'El Área de Conocimiento es obligatoria.',
            // Mensajes para el input txtotro_areaconocimiento
            'txtotro_areaconocimiento.required' => 'El otro área de conocimiento debe ser obligatorio.',
            'txtotro_areaconocimiento.max' => 'El otro área de conocimiento debe ser máximo de 100 carácteres.',
            // Mensajes para el input txtsublinea
            'txtsublinea_id.required' => 'La Sublínea es obligatoria.',
            // Mensajes para el input txttipo_economianaranja
            'txttipo_economianaranja.required' => 'El tipo de economía naranja debe ser obligatorio.',
            // 'txttipo_economianaranja.min' => 'El tipo de economía naranja debe ser mínimo de 5 carácteres.',
            'txttipo_economianaranja.max' => 'El tipo de economía naranja debe ser máximo de 100 carácteres.',
            // Mensajes para el input txttipo_discapacitados
            'txttipo_discapacitados.required' => 'El tipo de discapacidad debe ser obligatorio.',
            // 'txttipo_discapacitados.min' => 'El tipo de discapacidad debe ser mínimo de 5 carácteres.',
            'txttipo_discapacitados.max' => 'El tipo de discapacidad debe ser máximo de 100 carácteres.',
            // Mensajes para el input txttipo_discapacitados
            'txtnom_act_cti.required' => 'El nombre del actor CT+i debe ser obligatorio.',
            // 'txtnom_act_cti.min' => 'El nombre del actor CT+i debe ser mínimo de 5 carácteres.',
            'txtnom_act_cti.max' => 'El nombre del actor CT+i debe ser máximo de 100 carácteres.',
            // Mensaje de error para las etiquetas
            'tags.required' => 'Se debe seleccionar por lo menos una etiqueta.',
            // Mensajes para el input de talentos
            'talentos.required' => 'Debe asociar por lo menos un talento al proyecto.',
            // Mensajes para el input radioTalentoLider
            'radioTalentoLider.required' => 'El talento interlocutor del proyecto es obligatorio.',
            // Mensajes para el input txtobjetivo
            'txtobjetivo.required' => 'El objetivo general del proyecto es obligatorio.',
            'txtobjetivo.max' => 'El objetivo general del proyecto debe ser máximo de 500 carácteres.',
            // Mensajes para el input de txtalcance_proyecto
            'txtalcance_proyecto.required' => 'El alcance del proyecto es obligatorio.',
            'txtalcance_proyecto.max' => 'El alcance del proyecto debe ser máximo de 1000 carácteres.',
            // Mensajes para el input txtobjetivo_especifico1
            'txtobjetivo_especifico1.required' => 'El primer objetivo específico del proyecto es obligatorio.',
            'txtobjetivo_especifico1.max' => 'El primer objetivo específico del proyecto debe ser máximo de 500 carácteres.',
            // Mensajes para el input txtobjetivo_especifico2
            'txtobjetivo_especifico2.required' => 'El segundo objetivo específico del proyecto es obligatorio.',
            'txtobjetivo_especifico2.max' => 'El segundo objetivo específico del proyecto debe ser máximo de 500 carácteres.',
            // Mensajes para el input txtobjetivo_especifico3
            'txtobjetivo_especifico3.required' => 'El tercer objetivo específico del proyecto es obligatorio.',
            'txtobjetivo_especifico3.max' => 'El tercero objetivo específico del proyecto debe ser máximo de 500 carácteres.',
            // Mensajes para el input txtobjetivo_especifico4
            'txtobjetivo_especifico4.required' => 'El cuarto objetivo específico del proyecto es obligatorio.',
            'txtobjetivo_especifico4.max' => 'El cuarto objetivo específico del proyecto debe ser máximo de 500 carácteres.',
            // Mensajes para el input propietarios_user
            'propietarios_user.required' => 'Debe haber por lo menos un dueño de la propiedad intelectual.',
            // Mensajes para el input propietarios_sedes
            'propietarios_sedes.required' => 'Debe haber por lo menos un dueño de la propiedad intelectual.',
            // Mensajes para el input propietarios_grupos
            'propietarios_grupos.required' => 'Debe haber por lo menos un dueño de la propiedad intelectual.',
        ];
    }
}
