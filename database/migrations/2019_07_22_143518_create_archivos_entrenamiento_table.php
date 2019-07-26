<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosEntrenamientoTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('archivosentrenamiento', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('entrenamiento_id');
      $table->string('ruta',1000);
      $table->timestamps();

      $table->index(["entrenamiento_id"], 'fk_archivosentrenamiento_entrenamientos1_idx');

      $table->unique(["ruta"], 'ruta_UNIQUE');

      $table->foreign('entrenamiento_id', 'fk_archivosentrenamiento_entrenamientos1_idx')
      ->references('id')->on('entrenamientos')
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
    Schema::dropIfExists('archivosentrenamiento');
  }
}
