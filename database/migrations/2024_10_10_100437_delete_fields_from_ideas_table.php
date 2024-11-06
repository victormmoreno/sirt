<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFieldsFromIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_proyecto',
                'pregunta1',
                'pregunta2',
                'pregunta3',
                'descripcion',
                'objetivo',
                'alcance',
                'viene_convocatoria',
                'convocatoria',
                'aval_empresa',
                'empresa',
                'tipo_idea',
                'producto_parecido',
                'si_producto_parecido',
                'reemplaza',
                'si_reemplaza',
                'problema',
                'quien_compra',
                'quien_usa',
                'necesidades',
                'distribucion',
                'quien_entrega',
                'packing',
                'tipo_packing',
                'medio_venta',
                'valor_clientes',
                'requisitos_legales',
                'si_requisitos_legales',
                'requiere_certificaciones',
                'si_requiere_certificaciones',
                'forma_juridica',
                'version_beta',
                'cantidad_prototipos',
                'recursos_necesarios',
                'si_recursos_necesarios',
                'acuerdo_no_confidencialidad',
                'fecha_acuerdo_no_confidencialidad'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideas', function (Blueprint $table) {
            //
        });
    }
}
