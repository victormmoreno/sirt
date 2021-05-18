<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdeaFormRequest extends FormRequest
{
    public $type;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    function __construct(string $type)
    {
        $this->type = $type;
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
            'txtnombre_proyecto' => 'required|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_!@#$&()-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_!@#$&()-]*)*)+$/',
            'txtdescripcion' => $control . '|max:3400',
            'txtsi_producto_parecido' => Rule::requiredIf(request()->txtproducto_parecido == 1) . '|max:2100|nullable',
            'txtsi_reemplaza' => Rule::requiredIf(request()->txtreemplaza == 1) . '|max:2100|nullable',
            'txtproblema' => 'max:3400|'. $control,
            'txtnecesidades' => 'max:3400|'. $control,
            'txtquien_compra' => 'max:1400|'. $control,
            'txtquien_usa' => 'max:1400|'. $control,
            'txtdistribucion' => 'max:1400|'. $control,
            'txtquien_entrega' => 'max:1400|'. $control,
            'txttipo_packing' => Rule::requiredIf(request()->txtpacking == 1) . '|max:1400|nullable',
            'txtmedio_venta' => 'max:2100|' . $control,
            'txtvalor_clientes' => 'max:2100|' . $control,
            'txtsi_requisitos_legales' => Rule::requiredIf(request()->txtrequisitos_legales == 1) . '|max:2100|nullable',
            'txtsi_requiere_certificaciones' => Rule::requiredIf(request()->txtrequiere_certificaciones == 1) . '|max:2100|nullable',
            'txtsede_id' => Rule::requiredIf(request()->txtsede_id == 1 && request()->txtsede_id == null),
            'txtforma_juridica' => 'max:1400|'. $control,
            'txtlinkvideo' => 'nullable|url|max:1000',
            'txtversion_beta' => $control . '|max:200',
            'txtcantidad_prototipos' => $control . '|max:2100',
            'txtsi_recursos_necesarios' => Rule::requiredIf(request()->txtrecursos_necesarios == 1) . '|max:2100|nullable',
            'txtnodo' => 'required',
            'txtconvocatoria' => Rule::requiredIf(request()->txtviene_convocatoria == 1) . '|max:100|nullable',
            'txtempresa' => Rule::requiredIf(request()->txtaval_empresa == 1) . '|min:1|max:100|nullable'
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtnombre_proyecto.required' => 'El nombre de proyecto es obligatorio.',
            'txtnombre_proyecto.required.max' => 'El nombre de proyecto debe ser máximo 200 caracteres.',
            'txtnombre_proyecto.regex' => 'El formato del campo nombre de proyecto es incorrecto. (No usar :regex).',
            'txtdescripcion.max' => 'La descripcion debe ser máximo :max caracteres.',
            'txtdescripcion.required' => 'La descripcion es obligatoria.',
            'txtsi_producto_parecido.required' => 'El campo indicando como su producto o servicio mejora el que está actualmente en el país o su región es obligatorio.',
            'txtsi_producto_parecido.max' => 'El campo indicando como su producto o servicio mejora el que está actualmente en el país o su región debe ser máximo :max caracteres.',
            'txtsi_reemplaza.required' => 'El campo indicando cuál es esa solución, producto o servicio que reemplaza es obligatorio.',
            'txtsi_reemplaza.max' => 'El campo indicando cuál es esa solución, producto o servicio que reemplaza debe ser máximo :max caracteres.',
            'txtproblema.max' => 'El campo indicando cuál es problema que estan ayudando a solucionar a los clientes debe ser máximo :max caracteres.',
            'txtproblema.required' => 'El campo indicando cuál es problema que estan ayudando a solucionar a los clientes es obligatorio.',
            'txtnecesidades.max' => 'El campo indicando cuáles son las necesidades de los clientes que se satisfacen debe ser máximo :max caracteres.',
            'txtnecesidades.required' => 'El campo indicando cuáles son las necesidades de los clientes que se satisfacen es obligatorio.',
            'txtquien_compra.max' => 'El campo indicando quién comprará la solución, producto o servicio ser máximo :max caracteres.',
            'txtquien_compra.required' => 'El campo indicando quién comprará la solución, producto o servicio es obligatorio.',
            'txtquien_usa.max' => 'El campo indicando quien usará la solución, producto o servicio debe ser máximo :max caracteres.',
            'txtquien_usa.required' => 'El campo indicando quien usará la solución, producto o servicio es obligatorio.',
            'txtdistribucion.max' => 'El campo indicando cuales son los canales de distribución de los productos/servicios debe ser máximo :max caracteres.',
            'txtdistribucion.required' => 'El campo indicando cuales son los canales de distribución de los productos/servicios es obligatorio.',
            'txtquien_entrega.max' => 'El campo indicando quién va a entregar el producto/servicio debe ser máximo :max caracteres.',
            'txtquien_entrega.required' => 'El campo indicando quién va a entregar el producto/servicio es obligatorio.',
            'txttipo_packing.required' => 'El campo indicando que tipo de packing se requiere es obligatorio.',
            'txttipo_packing.max' => 'El campo indicando que tipo de packing se requiere debe ser máximo :max caracteres.',
            'txtmedio_venta.max' => 'El campo indicando cuál será el medio de venta del producto/servicio debe ser máximo :max caracteres.',
            'txtmedio_venta.required' => 'El campo indicando cuál será el medio de venta del producto/servicio es obligatorio.',
            'txtvalor_clientes.max' => 'El campo indicando cuanto es el valor que están dispuestos a pagar los cliente por el producto/servicio debe ser máximo :max caracteres.',
            'txtvalor_clientes.required' => 'El campo indicando cuanto es el valor que están dispuestos a pagar los cliente por el producto/servicio es obligatorio.',
            'txtsi_requisitos_legales.required' => 'El campo indicando cuales son los requisitos legales a considerar en los países en donde se va a vender es obligatorio.',
            'txtsi_requisitos_legales.max' => 'El campo indicando cuales son los requisitos legales a considerar en los países en donde se va a vender debe ser máximo :max caracteres.',
            'txtsi_requiere_certificaciones.required' => 'El campo indicando si se requieren certificaciones o permisos especiales es obligatorio.',
            'txtsi_requiere_certificaciones.max' => 'Este campo indicando si se requieren certificaciones o permisos especiales debe ser máximo :max caracteres.',
            'txtforma_juridica.max' => 'El campo indicando cuál es la forma jurídica que tendrá el negocio debe ser máximo :max caracteres.',
            'txtforma_juridica.required' => 'El campo indicando cuál es la forma jurídica que tendrá el negocio es obligatorio.',
            'txtlinkvideo.max' => 'El link del video debe ser máximo :max caracteres.',
            'txtlinkvideo.url' => 'El link del video debe ser una url válida.',
            'txtversion_beta.max' => 'El campo indicando si existe versión beta debe ser máximo :max caracteres.',
            'txtversion_beta.required' => 'El campo indicando si existe versión beta es obligatorio.',
            'txtcantidad_prototipos.max' => 'El campo indicando cuales y cuantos protitipos se necesitan desarrollar debe ser máximo :max caracteres.',
            'txtcantidad_prototipos.required' => 'El campo indicando cuales y cuantos protitipos se necesitan desarrollar es obligatorio.',
            'txtsi_recursos_necesarios.required' => 'El campo indicando si se dispone de recursos para el desarrollo de los prototipos necesarios es obligatorio.',
            'txtsi_recursos_necesarios.max' => 'El campo indicando si se dispone de recursos para el desarrollo de los prototipos necesarios debe ser máximo :max caracteres.',
            'txtnodo.required' => 'El nodo es obligatorio.',
            'txtconvocatoria.required' => 'El nombre de la convocatoria es obligatorio.',
            'txtconvocatoria.max' => 'El nombre de la convocatoria debe ser máximo :max caracteres.',
            'txtempresa.required' => 'El nombre de la entidad que avala es obligatorio.',
            'txtempresa.max' => 'El nombre de la entidad que avala debe ser máximo :max caracteres.',
            'txtsede_id.required' => 'La sede con la que se realizará la idea de proyecto es obligatoria.',
        ];
    }

}
