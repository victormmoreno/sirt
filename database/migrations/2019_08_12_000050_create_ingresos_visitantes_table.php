<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosVisitantesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'ingresos_visitantes';

    /**
     * Run the migrations.
     * @table ingresos_visitantes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('visitante_id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('servicio_id');
            $table->timestamp('fecha_ingreso');
            $table->time('hora_salida');
            $table->string('descripcion',2000)->nullable()->default(null);

            $table->index(["servicio_id"], 'fk_ingresos_visitantes_servicios1_idx');

            $table->index(["visitante_id"], 'fk_ingresos_visitantes_visitantes1_idx');

            $table->index(["nodo_id"], 'fk_ingresos_visitantes_nodos1_idx');
            $table->nullableTimestamps();


            $table->foreign('nodo_id', 'fk_ingresos_visitantes_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('servicio_id', 'fk_ingresos_visitantes_servicios1_idx')
                ->references('id')->on('servicios')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('visitante_id', 'fk_ingresos_visitantes_visitantes1_idx')
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
