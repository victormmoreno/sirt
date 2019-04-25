<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleMantenimientoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'detalle_mantenimiento';

    /**
     * Run the migrations.
     * @table detalle_mantenimiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_detalle');
            $table->integer('idmantenimiento')->unsigned();
            $table->integer('idequipo')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('tipo_mantenimiento_equipo');

            $table->index(["user_id"], 'user_id_detalle');

            $table->index(["idequipo"], 'id_equipo_detalle');

            $table->index(["idmantenimiento"], 'id_mante_detalle');


            $table->foreign('idequipo', 'id_equipo_detalle')
                ->references('id_equipo')->on('equipo')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idmantenimiento', 'id_mante_detalle')
                ->references('id_mantenimiento')->on('mantenimiento_equipo')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'user_id_detalle')
                ->references('id')->on('users')
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
