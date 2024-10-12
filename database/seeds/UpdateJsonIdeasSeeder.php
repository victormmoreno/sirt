<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateJsonIdeasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener todas las filas de la tabla
        $rows = DB::table('ideas')->get();

        foreach ($rows as $row) {
            // Combinar la información antigua en un solo arreglo
            $jsonData = [
                'nombre_proyecto' => [
                    'answer' => $row->nombre_proyecto,
                    'label' => 'Nombre de la idea de proyecto'
                ],
                'pregunta1' => [
                    'answer' => $row->pregunta1,
                    'label' => 'Estado actual la solución y/o idea de negocio'
                ],
                'pregunta2' => [
                    'answer' => $row->pregunta2,
                    'label' => '¿Cómo está conformado su equipo de trabajo?'
                ],
                'pregunta3' => [
                    'answer' => $this->getPregunta3($row->pregunta3),
                    'label' => '¿En qué categoría se clasifica su idea?'
                ],
                'descripcion' => [
                    'answer' => $row->descripcion,
                    'label' => 'Describa de forma concisa y clara de que trata su idea de emprendimiento, ¿qué productos o servicios va a ofertar?'
                ],
                'objetivo' => [
                    'answer' => $row->objetivo,
                    'label' => 'Objetivo de la idea de proyecto'
                ],
                'alcance' => [
                    'answer' => $row->alcance,
                    'label' => 'Alcance esperado de la idea de proyecto'
                ],
                'convocatoria' => [
                    'answer' => $row->convocatoria,
                    'label' => '¿Viene de una convocatoria?'
                ],
                'empresa' => [
                    'answer' => $row->empresa,
                    'label' => '¿La idea está avalada por una entidad?'
                ],
                'producto_parecido' => [
                    'answer' => $row->si_producto_parecido,
                    'label' => '¿Conoce una solución, producto, servicio o desarrollo parecido que actualmente esté disponible en el país o su región?'
                ], // Eliminar campo de si/no
                'reemplaza' => [
                    'answer' => $row->si_reemplaza,
                    'label' => '¿La solución, producto o servicio reemplaza a algún otro existente?'
                ], // Eliminar campo de si/no
                'problema' => [
                    'answer' => $row->problema,
                    'label' => '¿Qué problema de nuestros clientes (internos o externos) ayudamos a solucionar?'
                ],
                'quien_compra' => [
                    'answer' => $row->quien_compra,
                    'label' => '¿Quién comprará la solución, producto o servicio'
                ],
                'quien_usa' => [
                    'answer' => $row->quien_usa,
                    'label' => '¿Quién usará la solución, producto o servicio?'
                ],
                'necesidades' => [
                    'answer' => $row->necesidades,
                    'label' => '¿Qué necesidades de los clientes satisfacemos?'
                ],
                'distribucion' => [
                    'answer' => $row->distribucion,
                    'label' => '¿Cuáles son los canales de distribución de tus productos/servicios? ¿Cómo se va a entregar/prestar al cliente?'
                ],
                'quien_entrega' => [
                    'answer' => $row->quien_entrega,
                    'label' => '¿Vas a entregar directamente el producto y/o a través de intermediarios? ¿Por qué canales, on-line, punto de venta?'
                ],
                'tipo_packing' => [
                    'answer' => $row->tipo_packing,
                    'label' => '¿El producto o servicio requiere algún tipo de empaque, embalaje o envase?'
                ],
                'medio_venta' => [
                    'answer' => $row->medio_venta,
                    'label' => '¿Por qué medio se venderá el producto o servicio desarrollado?'
                ],
                'valor_clientes' => [
                    'answer' => $row->valor_clientes,
                    'label' => '¿Por qué valor están dispuestos a pagar nuestros clientes?'
                ],
                'requisitos_legales' => [
                    'answer' => $row->si_requisitos_legales,
                    'label' => '¿Hay requisitos legales a considerar en los países en donde se va a vender?'
                ],
                'requiere_certificaciones' => [
                    'answer' => $row->si_requiere_certificaciones,
                    'label' => '¿La solución y/o idea de negocio requiere certificaciones o permisos especiales?'
                ],
                'forma_juridica' => [
                    'answer' => $row->forma_juridica,
                    'label' => '¿Es de su interés constituirse como persona natural o persona jurídica?'
                ],
                'version_beta' => [
                    'answer' => $row->version_beta,
                    'label' => '¿La solución, producto o servicio está aún en concepto o ya hay un prototipo o versión Beta?'
                ],
                'cantidad_prototipos' => [
                    'answer' => $row->cantidad_prototipos,
                    'label' => '¿Cuáles y cuántos prototipos necesita desarrollar con la Red Tecnoparques?'
                ],
                'recursos_necesarios' => [
                    'answer' => $row->si_recursos_necesarios == null ? 'No hay información disponble' : $row->si_recursos_necesarios, 
                    'label' => '¿Cuenta con los recursos para la puesta en marcha del producto o servicio?'
                ],
                'fecha_acuerdo_no_confidencialidad' => [
                    'answer' => $row->fecha_acuerdo_no_confidencialidad,
                    'label' => 'Fecha de aceptación de acuerdo de no confidencialidad de la idea de proyecto'
                ],
                'pretende_forma_juridica' => [
                    'answer' => $row->forma_juridica,
                    'label' => '¿Es de interés constituirse como persona natural o persona jurídica?'
                ],
                'producto_minimo_viable' => [
                    'answer' => 'No hay información disponible',
                    'label' => '¿Cuenta con producto mínimo viable?'
                ],
                'ha_realizado_pruebas' => [
                    'answer' => 'No hay información disponible',
                    'label' => '¿Ha realizado pruebas del producto o servicio con posibles clientes? '
                ],
                'ha_generado_ventas' => [
                    'answer' => 'No hay información disponible',
                    'label' => '¿El producto o servicio ha generado ventas?'
                ],
                'modelo_negocio_definido' => [
                    'answer' => 'No hay información disponible',
                    'label' => '¿Hay un modelo de negocio definido?'
                ],
                'apoyo_requerido' => [
                    'answer' => 'No hay información disponible',
                    'label' => '¿Ha identificado algún tipo de recurso y/o apoyo requerido para la escalabilidad de la idea?'
                ],
                'estrategia_fijar_precio' => [
                    'answer' => 'No hay información disponible',
                    'label' => 'Cuenta con una estrategia para fijar el precio de su producto o servicio?'
                ],
            ];

            // Actualizar la fila con el nuevo campo JSON
            DB::table('ideas')
            ->where('id', $row->id)
            ->update(['datos_idea' => json_encode($jsonData)]);
        }
    }

    private function getPregunta3($pregunta3) {
        if ($pregunta3 == 2 || $pregunta3 == 5) {
            return 2;
        } else {
            return $pregunta3;
        }
    }
}
