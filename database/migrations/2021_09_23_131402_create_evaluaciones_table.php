<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluacionesTable extends Migration
{
    public $tableName = 'evaluaciones';
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
            $table->unsignedInteger('evaluador_id');
            $table->unsignedInteger('proyecto_id');
            $table->dateTime('fecha_asignacion');
            $table->dateTime('fecha_inicio_cumplimiento')->nullable();
            $table->dateTime('fecha_terminacion_cumplimiento')->nullable();
            $table->dateTime('fecha_inicio_calidad')->nullable();
            $table->dateTime('fecha_terminacion_calidad')->nullable();
            $table->dateTime('fecha_terminado')->nullable();
            $table->tinyInteger('aprobacion_cumplimiento')->nullable();
            $table->tinyInteger('aprobacion_calidad')->nullable();
            $table->timestamps();


            $table->foreign('evaluador_id')->references('id')->on('users');
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
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
