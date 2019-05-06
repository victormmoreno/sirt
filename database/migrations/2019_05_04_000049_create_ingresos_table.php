<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->dateTime('fechaingreso');
            $table->time('horasalida');
            $table->text('descripcion')->nullable();
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('servicio_id');
            $table->unsignedInteger('visitante_id');
            $table->timestamps();

            $table->index(["servicio_id"], 'fk_ingresos_servicios1_idx');

            $table->index(["visitante_id"], 'fk_ingresos_visitantes1_idx');

            $table->index(["nodo_id"], 'fk_ingresos_nodos1_idx');

            $table->foreign('nodo_id', 'fk_ingresos_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('servicio_id', 'fk_ingresos_servicios1_idx')
                ->references('id')->on('servicios')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('visitante_id', 'fk_ingresos_visitantes1_idx')
                ->references('id')->on('visitantes')
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
