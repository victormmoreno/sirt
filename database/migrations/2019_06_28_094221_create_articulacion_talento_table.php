<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulacionTalentoTable extends Migration
{
  /**
  * Schema table name to migrate
  * @var string
  */
  public $tableName = 'articulacion_talento';
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
        $table->unsignedInteger('talento_id');
        $table->tinyInteger('talento_lider');
        $table->timestamps();

        $table->index(["talento_id"], 'fk_articulacion_talento_talentos1_idx');

        $table->index(["articulacion_id"], 'fk_articulacion_talento_articulaciones1_idx');


        $table->foreign('articulacion_id', 'fk_articulacion_talento_articulaciones1_idx')
            ->references('id')->on('articulaciones')
            ->onDelete('no action')
            ->onUpdate('no action');

        $table->foreign('talento_id', 'fk_articulacion_talento_talentos1_idx')
            ->references('id')->on('talentos')
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
