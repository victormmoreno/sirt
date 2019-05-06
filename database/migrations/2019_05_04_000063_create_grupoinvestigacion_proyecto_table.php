<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupoinvestigacionProyectoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'grupoinvestigacion_proyecto';

    /**
     * Run the migrations.
     * @table grupoinvestigacion_proyecto
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('grupoinvestigacion_id');
            $table->unsignedInteger('proyecto_id');
            $table->timestamps();

            $table->index(["grupoinvestigacion_id"], 'fk_grupoinvestigacion_proyecto_gruposinvestigaciones1_idx');

            $table->index(["proyecto_id"], 'fk_grupoinvestigacion_proyecto_proyectos1_idx');

            $table->foreign('grupoinvestigacion_id', 'fk_grupoinvestigacion_proyecto_gruposinvestigaciones1_idx')
                ->references('id')->on('gruposinvestigaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('proyecto_id', 'fk_grupoinvestigacion_proyecto_proyectos1_idx')
                ->references('id')->on('proyectos')
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
