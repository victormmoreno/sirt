<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriosCalidadTable extends Migration
{
    public $tableName = 'criterios_calidad';
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
            $table->unsignedInteger('archivo_id');
            $table->unsignedInteger('evaluacion_id');
            $table->string('comentarios', 150); 
            $table->timestamps();

            $table->foreign('archivo_id')->references('id')->on('archivos_articulacion_proyecto');
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
