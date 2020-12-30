<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIdeasTable extends Migration
{
    public $tableName = 'ideas';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->text('descripcion', 3400)->nullable()->default(null)->comment('Indica de que trata la solución/idea de negocio.')->change();
            $table->string('nombres_contacto', 45)->nullable()->default(null)->comment('Nombre del contacto que inscribe la idea.')->change();
            $table->string('apellidos_contacto', 45)->nullable()->default(null)->comment('Apellidos del contacto que inscribe la idea.')->change();
            $table->string('correo_contacto', 100)->nullable()->default(null)->comment('Correo del contacto que inscribe la idea.')->change();
            $table->string('telefono_contacto', 11)->nullable()->default(null)->comment('Telefono del contacto que inscribe la idea.')->change();
            $table->tinyInteger('producto_parecido')->nullable()->default(null)->comment('Indica si hay una solución, producto, servicio o desarrollo parecido al de la idea que se va a desarrollar.');
            $table->text('si_producto_parecido', 2100)->nullable()->default(null)->comment('En caso de que producto_parecido sea SI(1) se indica como se va a mejorar.');
            $table->tinyInteger('reemplaza')->nullable()->default(null)->comment('Indica si la idea, producto o servicio reemplaza a otro ya existente.');
            $table->text('si_reemplaza', 2100)->nullable()->default(null)->comment('En caso de que si_reemplaza sea SI(1) se escribe cual.');
            $table->text('problema', 3400)->nullable()->default(null)->comment('Indica cual es el problema a solucionar con la idea de proyecto.');
            $table->text('quien_compra', 1400)->nullable()->default(null)->comment('Indica quien va a comprar la idea de proyecto.');
            $table->text('quien_usa', 1400)->nullable()->default(null)->comment('Indica quien va a usar la idea de proyecto.');
            $table->text('necesidades', 3400)->nullable()->default(null)->comment('Indica cuales son las necesidad de los clientes que va a satisfacer la idea de proyecto.');
            $table->text('distribucion', 1400)->nullable()->default(null)->comment('Indica como se va a distribuir el servicio/producto.');
            $table->text('quien_entrega', 1400)->nullable()->default(null)->comment('Indica si se va a entregar directamente el producto y/o a través de intermediarios.');
            $table->tinyInteger('packing')->nullable()->default(null)->comment('Indica si la idea, producto o servicio requiere packing.');
            $table->text('tipo_packing', 1400)->nullable()->default(null)->comment('En caso de que packing sea SI(1) se escribe que tipo de packing se usará.');
            $table->text('medio_venta', 2100)->nullable()->default(null)->comment('Indica el medio por el que se venderá el producto/servicio desarrollado.');
            $table->text('valor_clientes', 2100)->nullable()->default(null)->comment('Indica el valor que están dispuestos a pagar los clientes por el producto/servicio desarrollado.');
            $table->tinyInteger('requisitos_legales')->nullable()->default(null)->comment('Indica si hay requisitos legales a considerar en los países en donde se va a vender.');
            $table->text('si_requisitos_legales', 2100)->nullable()->default(null)->comment('En caso de que requisitos_legales sea SI(1) se escriben los requisitos.');
            $table->tinyInteger('requiere_certificaciones')->nullable()->default(null)->comment('Indica si el producto/servicio requiere certificaciones.');
            $table->text('si_requiere_certificaciones', 2100)->nullable()->default(null)->comment('En caso de que requiere_certificaciones sea SI(1) se escriben las certificaciones requeridas.');
            $table->text('forma_juridica', 1400)->nullable()->default(null)->comment('Indica la forma jurídica que va a tener el negocio.');
            $table->text('version_beta', 1400)->nullable()->default(null)->comment('Indica si la solucion/producto/servicio tiene un prototipo o versión beta.');
            $table->text('cantidad_prototipos', 2100)->nullable()->default(null)->comment('Indica la cantidad y cuales prototipos se necesitan desarrollar con la red tecnoparque.');
            $table->tinyInteger('recursos_necesarios')->nullable()->default(null)->comment('Indica si se dispone de recursos para el desarrollo de los prototipos necesarios?  .');
            $table->text('si_recursos_necesarios', 2100)->nullable()->default(null)->comment('En caso de que recursos_necesarios sea SI(1) se específican los recursos necesarios.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn(['producto_parecido',
            'si_producto_parecido', 'reemplaza',
            'si_reemplaza', 'problema',
            'quien_compra', 'quien_usa',
            'necesidades', 'distribucion',
            'quien_entrega', 'packing',
            'tipo_packing', 'medio_venta',
            'valor_clientes', 'requisitos_legales',
            'si_requisitos_legales', 'requiere_certificaciones',
            'si_requiere_certificaciones', 'forma_juridica',
            'version_beta', 'cantidad_prototipos',
            'recursos_necesarios', 'si_recursos_necesarios']);
        });
    }
}
