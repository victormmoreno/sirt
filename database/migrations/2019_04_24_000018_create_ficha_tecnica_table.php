<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichaTecnicaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ficha_tecnica';

    /**
     * Run the migrations.
     * @table ficha_tecnica
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_ficha');
            $table->string('nombre_ficha', 100);
            $table->string('nro_inventario', 45)->nullable()->default(null);
            $table->string('voltaje', 100)->nullable()->default(null);
            $table->string('potencia', 100)->nullable()->default(null);
            $table->date('fecha_adquisicion')->nullable()->default(null);
            $table->date('fecha_instalacion')->nullable()->default(null);
            $table->string('costo', 100)->nullable()->default(null);
            $table->integer('id_proveedor')->unsigned();
            $table->string('garantia', 100)->nullable()->default(null);
            $table->string('monitor', 100)->nullable()->default(null);
            $table->string('ram', 100)->nullable()->default(null);
            $table->string('disco_duro', 100)->nullable()->default(null);
            $table->string('impresora', 100)->nullable()->default(null);
            $table->string('mouse', 100)->nullable()->default(null);
            $table->string('teclado', 100)->nullable()->default(null);
            $table->string('sis_operativo', 100)->nullable()->default(null);
            $table->string('alto', 100)->nullable()->default(null);
            $table->string('ancho', 100)->nullable()->default(null);
            $table->string('largo', 100)->nullable()->default(null);
            $table->string('sede', 100)->nullable()->default(null);
            $table->string('edificio', 100)->nullable()->default(null);
            $table->string('usuario', 100)->nullable()->default(null);
            $table->integer('telefono')->nullable()->default(null);
            $table->integer('extension')->nullable()->default(null);
            $table->text('programas_instalados')->nullable()->default(null);

            $table->index(["id_proveedor"], 'ficha_proveedor');


            $table->foreign('id_proveedor', 'ficha_proveedor')
                ->references('id_proveedores')->on('proveedores')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
