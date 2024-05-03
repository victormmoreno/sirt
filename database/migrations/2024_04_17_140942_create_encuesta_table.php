<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEncuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->string('descripcion')->nullable();
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
        });

        Schema::create('secciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('encuesta_id');
            $table->string('titulo');
            $table->string('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('encuesta_id')
            ->references('id')->on('encuestas')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::create('tipos_pregunta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('preguntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seccion_id');
            $table->unsignedBigInteger('tipo_pregunta_id');
            $table->string('texto');
            $table->string('tipo');
            $table->timestamps();

            $table->foreign('seccion_id')
            ->references('id')->on('secciones')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('tipo_pregunta_id')
            ->references('id')->on('tipos_pregunta')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::create('opciones_respuesta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pregunta_id');
            $table->string('opcion');
            $table->timestamps();

            $table->foreign('pregunta_id')
            ->references('id')->on('preguntas')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::create('encuesta_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('encuesta_id');
            $table->unsignedInteger('user_id');
            $table->string('token', 100);
            // $table->tinyInteger('estado')->default(0);
            $table->timestamps();

            $table->foreign('encuesta_id')
            ->references('id')->on('encuestas')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::create('respuestas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('encuesta_id');
            $table->unsignedBigInteger('pregunta_id');
            $table->string('respuesta')->nullable();
            $table->string('opcion')->nullable();
            $table->timestamps();

            $table->foreign('pregunta_id')
            ->references('id')->on('preguntas')
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
        Schema::dropIfExists('encuestas');
        Schema::dropIfExists('secciones');
        Schema::dropIfExists('tipos_pregunta');
        Schema::dropIfExists('preguntas');
        Schema::dropIfExists('opciones_respuesta');
        Schema::dropIfExists('encuesta_tokens');
        Schema::dropIfExists('respuestas');
    }
}
