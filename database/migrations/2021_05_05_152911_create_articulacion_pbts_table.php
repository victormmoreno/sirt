<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulacionPbtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulacion_pbts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedInteger('actividad_id');
            $table->unsignedInteger('proyecto_id');
            $table->unsignedInteger('fase_id');
            $table->unsignedBigInteger('tipo_articulacion_id');
            $table->unsignedBigInteger('alcance_articulacion_id');
            $table->string('entidad')->nullable();
            $table->string('nombre_contacto')->nullable();
            $table->string('email_entidad')->nullable();
            $table->string('nombre_convocatoria')->nullable();
            $table->text('objetivo')->nullable();
            $table->text('lecciones_aprendidas')->nullable();
            $table->timestamps();  

            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            $table->foreign('fase_id')->references('id')->on('fases')->onDelete('cascade');
            $table->foreign('tipo_articulacion_id')->references('id')->on('tipo_articulaciones')->onDelete('cascade');
            $table->foreign('alcance_articulacion_id')->references('id')->on('alcance_articulaciones')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulacion_pbts');
    }
}
