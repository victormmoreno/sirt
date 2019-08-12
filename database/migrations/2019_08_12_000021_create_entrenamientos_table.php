<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrenamientosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'entrenamientos';

    /**
     * Run the migrations.
     * @table entrenamientos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fecha_sesion1');
            $table->date('fecha_sesion2');
            $table->string('codigo_entrenamiento', 20);
            $table->tinyInteger('correos')->nullable()->default('0');
            $table->tinyInteger('fotos')->nullable()->default('0');
            $table->tinyInteger('listado_asistencia')->nullable()->default('0');

            $table->unique(["codigo_entrenamiento"], 'codigo_entrenamiento_UNIQUE');
            $table->nullableTimestamps();
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
