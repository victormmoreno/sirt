<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposEdtTable extends Migration
{

    /**
     * nombre de la tabla
     *
     * @var string
     */
    public $tableName = 'tiposedt';
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
          $table->string('nombre', 100);
          $table->string('observaciones', 500);

          $table->unique(["nombre"], 'nombre_UNIQUE');

          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiposedt');
    }
}
