<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulacionEmprendedorTable extends Migration
{

  public $tableName = 'articulacion_emprendedor';

  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create($this->tableName, function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->unsignedInteger('articulacion_id');
      $table->string('documento', 20);
      $table->string('nombres', 50);
      $table->string('email', 100);
      $table->string('contacto', 15);
      $table->timestamps();

      $table->index(["articulacion_id"], 'fk_articulacion_emprendedor_articulacion1_idx');

      $table->foreign('articulacion_id', 'fk_articulacion_emprendedor_articulacion1_idx')
          ->references('id')->on('articulaciones')
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
