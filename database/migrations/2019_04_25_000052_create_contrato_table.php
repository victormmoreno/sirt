<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'contrato';

    /**
     * Run the migrations.
     * @table contrato
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_contrato');
            $table->string('numero_contrato', 45)->nullable()->default(null);
            $table->integer('mantenimiento')->unsigned();
            $table->integer('proveedor')->unsigned();
            $table->date('fecha_contrato')->nullable()->default(null);
            $table->date('fecha_fin')->nullable()->default(null);
            $table->integer('costo')->nullable()->default(null);
            $table->tinyInteger('estado_contrato')->nullable()->default(null);

            $table->index(["proveedor"], 'contrato_id_proveedor');

            $table->index(["mantenimiento"], 'contrato_mante');


            $table->foreign('mantenimiento', 'contrato_mante')
                ->references('id_mantenimiento')->on('mantenimiento_equipo')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('proveedor', 'contrato_id_proveedor')
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
