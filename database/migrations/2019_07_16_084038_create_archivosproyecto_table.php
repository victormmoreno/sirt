<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivosproyecto', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('proyecto_id');
          $table->unsignedInteger('fase_id');
          $table->string('ruta',1000);
          $table->timestamps();

          $table->index(["proyecto_id"], 'fk_archivosproyecto_proyectos1_idx');

          $table->index(["fase_id"], 'fk_archivosproyecto_fases1_idx');

          $table->unique(["ruta"], 'ruta_UNIQUE');

          $table->foreign('proyecto_id', 'fk_archivosproyecto_proyectos1_idx')
              ->references('id')->on('proyectos')
              ->onDelete('no action')
              ->onUpdate('no action');

          $table->foreign('fase_id', 'fk_archivosproyecto_fases1_idx')
              ->references('id')->on('fases')
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
        Schema::dropIfExists('archivosproyecto');
    }
}
