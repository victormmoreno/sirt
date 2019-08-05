<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivoscharlasinformativasTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('archivoscharlasinformativas', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('charlainformativa_id');
      $table->string('ruta',1000);
      $table->timestamps();

      $table->index(["charlainformativa_id"], 'fk_archivoscharlasinformativas_charlasinformativas1_idx');

      $table->unique(["ruta"], 'ruta_UNIQUE');

      $table->foreign('charlainformativa_id', 'fk_archivoscharlasinformativas_charlasinformativas1_idx')
      ->references('id')->on('charlasinformativas')
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
    Schema::dropIfExists('archivoscharlasinformativas');
  }
}
