<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('encuestable');
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });

        Schema::create('resultados_encuesta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('proyecto_id');
            $table->unsignedInteger('user_id');
            $table->longText('resultados')->nullable();
            $table->dateTime('fecha_envio')->nullable();
            $table->dateTime('fecha_respuesta')->nullable();
            $table->timestamps();

            $table->foreign('proyecto_id')
            ->references('id')->on('proyectos')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('user_id')
            ->references('id')->on('users')
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
        Schema::dropIfExists('encuesta_tokens');
        Schema::dropIfExists('resultados_encuesta');
    }
}
