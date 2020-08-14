<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proyectos';

    /**
     * Run the migrations.
     * @table proyectos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('articulacion_proyecto_id');
            $table->unsignedInteger('idea_id');
            $table->unsignedInteger('sublinea_id');
            $table->unsignedInteger('areaconocimiento_id');
            $table->tinyInteger('economia_naranja')->nullable()->default('0');
            $table->tinyInteger('art_cti')->nullable()->default('0');
            $table->string('nom_act_cti', 50)->nullable()->default(null);
            $table->tinyInteger('diri_ar_emp')->nullable()->default('0');
            $table->tinyInteger('reci_ar_emp')->nullable()->default('0');
            $table->tinyInteger('acc')->nullable()->default('0');
            $table->tinyInteger('manual_uso_inf')->nullable()->default('0');
            $table->tinyInteger('estado_arte')->nullable()->default('0');

            $table->index(["sublinea_id"], 'fk_proyectos_sublineas1_idx');

            $table->index(["areaconocimiento_id"], 'fk_proyectos_areasconocimiento1_idx');

            $table->index(["idea_id"], 'fk_proyectos_idea1_idx');

            $table->index(["articulacion_proyecto_id"], 'fk_proyectos_articulacion_proyecto1_idx');

            $table->nullableTimestamps();


            $table->foreign('areaconocimiento_id', 'fk_proyectos_areasconocimiento1_idx')
                ->references('id')->on('areasconocimiento')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idea_id', 'fk_proyectos_idea1_idx')
                ->references('id')->on('ideas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sublinea_id', 'fk_proyectos_sublineas1_idx')
                ->references('id')->on('sublineas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('articulacion_proyecto_id', 'fk_proyectos_articulacion_proyecto1_idx')
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
