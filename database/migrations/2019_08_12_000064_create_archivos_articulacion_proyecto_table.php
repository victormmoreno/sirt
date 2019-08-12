<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosArticulacionProyectoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'archivos_articulacion_proyecto';

    /**
     * Run the migrations.
     * @table archivos_articulacion_proyecto
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('fase_id');
            $table->unsignedInteger('articulacion_proyecto_id');
            $table->string('ruta');

            $table->index(["articulacion_proyecto_id"], 'fk_archivosarticulaciones_articulacion_proyecto1_idx');

            $table->index(["fase_id"], 'fk_archivosarticulaciones_fases1_idx');

            $table->unique(["articulacion_proyecto_id"], 'articulacion_proyecto_id_UNIQUE');

            $table->unique(["ruta"], 'ruta_UNIQUE');
            $table->nullableTimestamps();


            $table->foreign('fase_id', 'fk_archivosarticulaciones_fases1_idx')
                ->references('id')->on('fases')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('articulacion_proyecto_id', 'fk_archivosarticulaciones_articulacion_proyecto1_idx')
                ->references('id')->on('articulacion_proyecto')
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
