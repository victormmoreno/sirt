<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentroformacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centroformacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ciudad')->unsigned();
            $table->string('titulo',700);
            $table->string('nombre',1000);
            $table->string('direccion',100);
            $table->text('descripcion');
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->timestamps();

            $table->foreign('ciudad')->references('idciudad')->on('ciudad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centroformacion');
    }
}
