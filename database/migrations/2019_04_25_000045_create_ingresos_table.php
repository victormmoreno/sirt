<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ingresos';

    /**
     * Run the migrations.
     * @table ingresos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idingresos');
            $table->integer('nodo')->unsigned();
            $table->integer('servicio')->unsigned();
            $table->integer('visitante')->unsigned();
            $table->dateTime('fechaingreso')->nullable()->default(null);
            $table->string('descripcion', 200)->nullable()->default(null);
            $table->time('horasalida')->nullable()->default(null);

            $table->index(["servicio"], 'fk_ingresos_servicio1_idx');

            $table->index(["nodo"], 'fk_ingresos_nodo1_idx');

            $table->index(["visitante"], 'fk_ingresos_visitante1_idx');


            $table->foreign('nodo', 'fk_ingresos_nodo1_idx')
                ->references('idnodo')->on('nodo')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('servicio', 'fk_ingresos_servicio1_idx')
                ->references('idservicio')->on('servicio')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('visitante', 'fk_ingresos_visitante1_idx')
                ->references('idvisitante')->on('visitante')
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
