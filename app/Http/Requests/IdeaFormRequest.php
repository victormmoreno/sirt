<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdeaFormRequest extends FormRequest
{
    public $type;
    public $empresa;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    function __construct(string $type, $empresa)
    {
        $this->type = $type;
        $this->empresa = $empresa;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $control = 'nullable';
        if ($this->type == "postular") {
            $control = 'required';
        }
        return [
            'check_acuerdo_no_confidencialidad' => 'required',
            'txt_nombre_proyecto' => 'required|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_!@#$&()-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_!@#$&()-]*)*)+$/',
            'txt_descripcion' => $control . '|max:3400',
            'txt_si_producto_parecido' => Rule::requiredIf(request()->check_producto_parecido == 1) . '|max:2100|nullable',
            'txt_si_reemplaza' => Rule::requiredIf(request()->check_reemplaza == 1) . '|max:2100|nullable',
            // 'check_producto_minimo_viable' =>
            'radio_pregunta1' => $control,
            'txt_problema' => 'max:3400|'. $control,
            'txt_necesidades' => 'max:3400|'. $control,
            // 'txtquien_compra' => 'max:1400|'. $control,
            'txt_quien_usa' => 'max:1400|'. $control,
            'radio_apoyo_requerido' => $control,
            'radio_pregunta2' => $control,
            // 'txtdistribucion' => 'max:1400|'. $control,
            // 'txtquien_entrega' => 'max:1400|'. $control,
            // 'txttipo_packing' => Rule::requiredIf(request()->txtpacking == 1) . '|max:1400|nullable',
            // 'txtmedio_venta' => 'max:2100|' . $control,
            // 'txtvalor_clientes' => 'max:2100|' . $control,
            'txt_si_requisitos_legales' => Rule::requiredIf(request()->check_requisitos_legales == 1) . '|max:2100|nullable',
            'txt_si_requiere_certificaciones' => Rule::requiredIf(request()->check_requiere_certificaciones == 1) . '|max:2100|nullable',
            // 'txtforma_juridica' => 'max:1400|'. $control,
            'txt_link_video' => 'nullable|url|max:1000',
            'radio_version_beta' => $control,
            'txt_cantidad_prototipos' => $control,
            'radio_pregunta3' => $control,
            // 'txtsi_recursos_necesarios' => Rule::requiredIf(request()->txtrecursos_necesarios == 1) . '|max:2100|nullable',
            'slct_nodo' => 'required',
            'txt_convocatoria' => Rule::requiredIf(request()->check_convocatoria == 1) . '|max:100|nullable',
            'txt_empresa' => Rule::requiredIf(request()->check_aval_empresa == 1) . '|min:1|max:100|nullable',
            'txt_sede_id' => Rule::requiredIf(request()->check_idea_empresa == 1 && $this->empresa != null)
        ];
    }

    public function messages()
    {
        return $messages = [
            'check_acuerdo_no_confidencialidad.required' => 'Debe aceptar el acuerdo de no confidencialidad de la idea.',
            'radio_pregunta3.required' => 'Debe especificar la categoria en la que clasifica su idea de proyecto.',
            'radio_pregunta1.required' => 'Debe especificar el estado actual de la idea de proyecto.',
            'radio_apoyo_requerido.required' => 'Debe especificar si ha identificado algún tipo de recurso y/o apoyo requerido para la escalabilidad de la idea.',
            'radio_pregunta2.required' => 'Debe especificar como está conformado su equipo de trabajo.',
            'txt_nombre_proyecto.required' => 'El nombre de proyecto es obligatorio.',
            'txt_nombre_proyecto.required.max' => 'El nombre de proyecto debe ser máximo 200 caracteres.',
            'txt_nombre_proyecto.regex' => 'El formato del campo nombre de proyecto es incorrecto. (No usar :regex).',
            'txt_descripcion.max' => 'La descripcion debe ser máximo :max caracteres.',
            'txt_descripcion.required' => 'La descripcion es obligatoria.',
            'txt_si_producto_parecido.required' => 'El campo indicando como su producto o servicio mejora el que está actualmente en el país o su región es obligatorio.',
            'txt_si_producto_parecido.max' => 'El campo indicando como su producto o servicio mejora el que está actualmente en el país o su región debe ser máximo :max caracteres.',
            'txt_si_reemplaza.required' => 'El campo indicando cuál es esa solución, producto o servicio que reemplaza es obligatorio.',
            'txt_si_reemplaza.max' => 'El campo indicando cuál es esa solución, producto o servicio que reemplaza debe ser máximo :max caracteres.',
            'txt_problema.max' => 'El campo indicando cuál es problema que estan ayudando a solucionar a los clientes debe ser máximo :max caracteres.',
            'txt_problema.required' => 'El campo indicando cuál es problema que estan ayudando a solucionar a los clientes es obligatorio.',
            'txt_necesidades.max' => 'El campo indicando cuáles son las necesidades de los clientes que se satisfacen debe ser máximo :max caracteres.',
            'txt_necesidades.required' => 'El campo indicando cuáles son las necesidades de los clientes que se satisfacen es obligatorio.',
            // 'txtquien_compra.max' => 'El campo indicando quién comprará la solución, producto o servicio ser máximo :max caracteres.',
            // 'txtquien_compra.required' => 'El campo indicando quién comprará la solución, producto o servicio es obligatorio.',
            'txt_quien_usa.max' => 'El campo indicando quien usará la solución, producto o servicio debe ser máximo :max caracteres.',
            'txt_quien_usa.required' => 'El campo indicando quien usará la solución, producto o servicio es obligatorio.',
            // 'txtdistribucion.max' => 'El campo indicando cuales son los canales de distribución de los productos/servicios debe ser máximo :max caracteres.',
            // 'txtdistribucion.required' => 'El campo indicando cuales son los canales de distribución de los productos/servicios es obligatorio.',
            // 'txtquien_entrega.max' => 'El campo indicando quién va a entregar el producto/servicio debe ser máximo :max caracteres.',
            // 'txtquien_entrega.required' => 'El campo indicando quién va a entregar el producto/servicio es obligatorio.',
            // 'txttipo_packing.required' => 'El campo indicando que tipo de packing se requiere es obligatorio.',
            // 'txttipo_packing.max' => 'El campo indicando que tipo de packing se requiere debe ser máximo :max caracteres.',
            // 'txtmedio_venta.max' => 'El campo indicando cuál será el medio de venta del producto/servicio debe ser máximo :max caracteres.',
            // 'txtmedio_venta.required' => 'El campo indicando cuál será el medio de venta del producto/servicio es obligatorio.',
            // 'txtvalor_clientes.max' => 'El campo indicando cuanto es el valor que están dispuestos a pagar los cliente por el producto/servicio debe ser máximo :max caracteres.',
            // 'txtvalor_clientes.required' => 'El campo indicando cuanto es el valor que están dispuestos a pagar los cliente por el producto/servicio es obligatorio.',
            'txt_si_requisitos_legales.required' => 'El campo indicando cuales son los requisitos legales a considerar en los países en donde se va a vender es obligatorio.',
            'txt_si_requisitos_legales.max' => 'El campo indicando cuales son los requisitos legales a considerar en los países en donde se va a vender debe ser máximo :max caracteres.',
            'txt_si_requiere_certificaciones.required' => 'El campo indicando si se requieren certificaciones o permisos especiales es obligatorio.',
            'txt_si_requiere_certificaciones.max' => 'Este campo indicando si se requieren certificaciones o permisos especiales debe ser máximo :max caracteres.',
            // 'txtforma_juridica.max' => 'El campo indicando cuál es la forma jurídica que tendrá el negocio debe ser máximo :max caracteres.',
            // 'txtforma_juridica.required' => 'El campo indicando cuál es la forma jurídica que tendrá el negocio es obligatorio.',
            'txt_link_video.max' => 'El link del video debe ser máximo :max caracteres.',
            'txt_link_video.url' => 'El link del video debe ser una url válida.',
            // 'txtversion_beta.max' => 'El campo indicando si existe versión beta debe ser máximo :max caracteres.',
            'txtversion_beta.required' => 'Debe especificar ya hay un prototipo o versión beta de su idea o producto.',
            'txt_cantidad_prototipos.max' => 'El campo indicando cuales y cuantos protitipos se necesitan desarrollar debe ser máximo :max caracteres.',
            'txt_cantidad_prototipos.required' => 'El campo indicando cuales y cuantos protitipos se necesitan desarrollar es obligatorio.',
            // 'txtsi_recursos_necesarios.required' => 'El campo indicando si se dispone de recursos para el desarrollo de los prototipos necesarios es obligatorio.',
            // 'txtsi_recursos_necesarios.max' => 'El campo indicando si se dispone de recursos para el desarrollo de los prototipos necesarios debe ser máximo :max caracteres.',
            'slct_nodo.required' => 'El nodo es obligatorio.',
            'txt_convocatoria.required' => 'El nombre de la convocatoria es obligatorio.',
            'txt_convocatoria.max' => 'El nombre de la convocatoria debe ser máximo :max caracteres.',
            'txt_empresa.required' => 'El nombre de la entidad que avala es obligatorio.',
            'txt_empresa.max' => 'El nombre de la entidad que avala debe ser máximo :max caracteres.',
            'txt_sede_id.required' => 'La sede con la que se realizará la idea de proyecto es obligatoria.',
        ];
    }

}
