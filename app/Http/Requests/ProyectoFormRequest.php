<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{TipoArticulacionProyecto, EstadoProyecto, EstadoPrototipo};
use Illuminate\Validation\Rule;

class ProyectoFormRequest extends FormRequest
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
      'txttipoarticulacionproyecto_id' => 'required',
      'txtotro_tipoarticulacion' => Rule::requiredIf(request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Otro')->first()->id). '|min:5|max:50|nullable',
      'txtsublinea_id' => 'required',
      'txtsector_id' => 'required',
      'txtareaconocimiento_id' => 'required',
      'txtestadoproyecto_id' => 'required',
      'txtnombre' => 'required|min:10|max:200',
      'txtentidad_proyecto_id' => Rule::requiredIf(
        request()->txttipoarticulacionproyecto_id != TipoArticulacionProyecto::where('nombre', 'Otro')->first()->id &&
        request()->txttipoarticulacionproyecto_id != TipoArticulacionProyecto::where('nombre', 'Proyecto financiado por SENNOVA')->first()->id &&
        request()->txttipoarticulacionproyecto_id != TipoArticulacionProyecto::where('nombre', 'Emprendedor')->first()->id &&
        request()->txttipoarticulacionproyecto_id != TipoArticulacionProyecto::where('nombre', 'Universidades')->first()->id
      ),
      'txtuniversidad_proyecto' => Rule::requiredIf(request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Universidades')->first()->id) . '|max:50',
      'txtfecha_inicio' => 'required|date_format:"Y-m-d"',
      'txtidea_id' => 'required',
      'txtfecha_fin' => Rule::requiredIf(request()->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PF')->first()->id || request()->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PMV')->first()->id). '|date_format:"Y-m-d"|nullable',
      'txtestadoprototipo_id' => Rule::requiredIf(request()->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PF')->first()->id || request()->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PMV')->first()->id),
      'txtresultado_proyecto' => Rule::requiredIf(request()->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PF')->first()->id || request()->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PMV')->first()->id) .'|max:1000',
      'txtotro_estadoprototipo' => Rule::requiredIf(request()->txtestadoprototipo_id == EstadoPrototipo::where('nombre', 'Otro.')->first()->id) . '|min:5|max:50|nullable',
      'txtnom_act_cti' => Rule::requiredIf(request()->txtarti_cti == 1). '|min:5|max:50|nullable',
      'txtimpacto_proyecto' => 'max:1000',
      'txtobservaciones_proyecto' => 'max:1000',
      'talentos' => 'required',
      'radioTalentoLider' => 'required'
      ];
    }

    public function messages()
    {
      return $messages = [
      // Mensaje para el input txttipoarticulacionproyecto_id
      'txttipoarticulacionproyecto_id.required' => 'El Tipo de Articulación es obligatorio.',
      // Mensajes para el input txtotro_tipoarticulacion
      'txtotro_tipoarticulacion.required' => 'El nombre del otro tipo de articulación el obligatorio.',
      'txtotro_tipoarticulacion.min' => 'El nombre del otro tipo de articulación debe ser mínimo de 5 carácteres.',
      'txtotro_tipoarticulacion.max' => 'El nombre del otro tipo de articulación debe ser máximo de 50 carácteres.',
      // Mensajes para el input
      'txtsublinea_id.required' => 'La Sublínea es obligatoria.',
      // Mensajes para el input txtsector_id
      'txtsector_id.required' => 'El Sector es obligatorio.',
      // Mensajes para el input txtareaconocimiento_id
      'txtareaconocimiento_id.required' => 'La Área de Conocimiento es obligatoria.',
      // Mensajes para el input txtestadoproyecto_id
      'txtestadoproyecto_id.required' => 'El Estaodo del Proyecto es obligatorio.',
      // Mensajes para el input txtnombre
      'txtnombre.required' => 'El Nombre del Proyecto es obligatorio.',
      'txtnombre.min' => 'El Nombre del Proyecto debe ser mínimo 10 carácteres.',
      'txtnombre.max' => 'El Nombre del Proyecto debe ser máximo 200 carácteres.',
      // Mensajes para el input txtentidad_proyecto_id
      'txtentidad_proyecto_id.required' => 'Debe asociar una entidad al proyecto.',
      // Mensajes para el input txtuniversidad_proyecto
      'txtuniversidad_proyecto.required' => 'El nombre de la universidad es obligatorio.',
      // Mensajes para el input txtfecha_inicio
      'txtfecha_inicio.required' => 'La Fecha de Inicio es obligatoria.',
      'txtfecha_inicio.date_format' => 'El formato de la Fecha de Inicio es incorrecto.',
      // Mensajes para el input txtestadoprototipo_id
      'txtestadoprototipo_id.required' => 'El Estado del Prototipo es obligatorio.',
      // Mensajes para el input txtotro_estadoprototipo
      'txtotro_estadoprototipo.required' => 'El nombre del otro estado del prototipo es obligatorio.',
      'txtotro_estadoprototipo.min' => 'El nombre del otro estado del prototipo debe ser mínimo de 5 carácteres.',
      'txtotro_estadoprototipo.max' => 'El nombre del otro estado del prototipo debe ser máximo de 50 carácteres.',
      // Mensajes para el input txtresultado_proyecto
      'txtresultado_proyecto.required' => 'Los resultados del proyecto son obligatorios.',
      'txtresultado_proyecto.max' => 'Los resultados del proyecto deben ser máximo 1000 carácteres.',
      // Mensajes para el input txtfecha_fin
      'txtfecha_fin.required' => 'La Fecha de Cierre es obligatoria.',
      'txtfecha_fin.date_format' => 'El formato de la Fecha de Cierre es incorrecto.',
      // Mensajes para el input
      'txtidea_id.required' => 'La idea de proyecto es obligatoria.',
      // Mensajes para el input txtnom_act_cti
      'txtnom_act_cti.required' => 'El Nombre del Actor CT+i es obligatorio.',
      'txtnom_act_cti.min' => 'El Nombre del Actor CT+i es debe ser mínimo de 5 carácteres.',
      'txtnom_act_cti.max' => 'El Nombre del Actor CT+i es debe ser máximo de 50 carácteres.',
      // Mensajes para el input txtimpacto_proyecto
      'txtimpacto_proyecto.max' => 'El Impacto del Proyecto debe ser máximo 1000 carácteres.',
      // Mensajes para el input txtobservaciones_proyecto
      'txtobservaciones_proyecto.max' => 'Las Observaciones del Proyecto debe ser máximo 1000 carácteres.',
      // Mensajes para el input de talentos
      'talentos.required' => 'Debe asociar por lo menos un talento al proyecto.',
      // Mensajes para el input radioTalentoLider
      'radioTalentoLider.required' => 'El talento líder del proyecto es obligatorio.'
      ];
    }

    /**
     * Este método al parece no funciona desde laravel 5.8.27
     */
    public function attributes()
    {
      return [
        'txtestadoprototipo_id.required' => 'adwedasd',
      ];
    }
  }
