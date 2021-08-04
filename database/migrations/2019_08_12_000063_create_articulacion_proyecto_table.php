<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulacionProyectoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'articulacion_proyecto';

    /**
     * Run the migrations.
     * @table articulacion_proyecto
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('entidad_id');
            $table->unsignedInteger('actividad_id');
            $table->tinyInteger('acta_cierre')->default('0');

            $table->index(["actividad_id"], 'fk_articulacion_proyecto_actividades1_idx');

            $table->index(["entidad_id"], 'fk_articulacion_proyecto_entidades1_idx');
            $table->nullableTimestamps();


            $table->foreign('entidad_id', 'fk_articulacion_proyecto_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('actividad_id', 'fk_articulacion_proyecto_actividades1_idx')
                ->references('id')->on('actividades')
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
