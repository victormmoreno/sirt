<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriosCumplimientoTable extends Migration
{
    public $tableName = 'criterios_cumplimiento';
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
            $table->unsignedInteger('fase_id');
            $table->unsignedInteger('evaluacion_id');
            $table->string('comentarios', 150);
            $table->timestamps();

            $table->foreign('fase_id')->references('id')->on('fases');
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones');
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
