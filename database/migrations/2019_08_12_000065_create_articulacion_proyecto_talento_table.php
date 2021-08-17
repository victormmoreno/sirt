<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulacionProyectoTalentoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'articulacion_proyecto_talento';

    /**
     * Run the migrations.
     * @table articulacion_proyecto_talento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('articulacion_proyecto_id');
            $table->unsignedInteger('talento_id');
            $table->tinyInteger('talento_lider')->default('0');

            $table->index(["articulacion_proyecto_id"], 'fk_proyecto_talento_articulacion_proyecto1_idx');

            $table->index(["talento_id"], 'fk_proyecto_talento_talentos1_idx');
            $table->nullableTimestamps();


            $table->foreign('talento_id', 'fk_proyecto_talento_talentos1_idx')
                ->references('id')->on('talentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('articulacion_proyecto_id', 'fk_proyecto_talento_articulacion_proyecto1_idx')
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
