<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'actividades';

    /**
     * Run the migrations.
     * @table actividades
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('gestor_id');
            $table->unsignedInteger('nodo_id');
            $table->string('codigo_actividad', 20);
            $table->string('nombre', 200);
            $table->date('fecha_inicio');
            $table->date('fecha_cierre')->nullable();

            $table->index(["nodo_id"], 'fk_actividades_nodos1_idx');

            $table->index(["gestor_id"], 'fk_actividades_gestores1_idx');

            $table->unique(["codigo_actividad"], 'codigo_actividad_UNIQUE');
            $table->nullableTimestamps();


            $table->foreign('gestor_id', 'fk_actividades_gestores1_idx')
                ->references('id')->on('gestores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('nodo_id', 'fk_actividades_nodos1_idx')
                ->references('id')->on('nodos')
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
