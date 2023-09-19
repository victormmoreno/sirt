<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProrrogaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prorroga_proyecto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('proyecto_id');
            $table->date('fecha_ejecucion');
            $table->timestamps();

            $table->foreign('proyecto_id')
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
        Schema::dropIfExists('prorroga_proyecto');
    }
}
