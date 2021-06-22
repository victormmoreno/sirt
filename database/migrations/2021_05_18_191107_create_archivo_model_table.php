<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivoModelTable extends Migration
{
    public $tableName = 'archivo_model';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('model_id')->unsigned();
            $table->string('model_type');
            $table->string('ruta', 1000)->nullable();
            $table->unsignedInteger('fase_id');
            $table->timestamps();

            $table->foreign('fase_id')->references('id')->on('fases')->onDelete('cascade');
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
