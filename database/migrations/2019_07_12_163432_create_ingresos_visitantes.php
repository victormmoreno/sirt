<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosVisitantes extends Migration
{

    public $tableName = 'ingresos_visitantes';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visitante_id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('servicio_id');
            $table->timestamp('fecha_ingreso');
            $table->time('hora_salida');
            $table->string('descripcion',2000)->nullable();
            $table->timestamps();

            $table->index(["visitante_id"], 'fk_ingresos_visitantes_visitantes1_idx');

            $table->index(["nodo_id"], 'fk_ingresos_visitantes_nodos1_idx');
            $table->index(["servicio_id"], 'fk_ingresos_visitantes_servicios1_idx');

            $table->foreign('visitante_id', 'fk_ingresos_visitantes_visitantes1_idx')
            ->references('id')->on('visitantes')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('nodo_id', 'fk_ingresos_visitantes_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');
        

            $table->foreign('servicio_id', 'fk_ingresos_visitantes_servicios1_idx')
                ->references('id')->on('servicios')
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
