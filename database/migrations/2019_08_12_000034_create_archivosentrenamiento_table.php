<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosentrenamientoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'archivosentrenamiento';

    /**
     * Run the migrations.
     * @table archivosentrenamiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('entrenamiento_id');
            $table->string('ruta');

            $table->index(["entrenamiento_id"], 'fk_archivosentrenamiento_entrenamientos1_idx');

            $table->unique(["ruta"], 'ruta_UNIQUE');
            $table->nullableTimestamps();


            $table->foreign('entrenamiento_id', 'fk_archivosentrenamiento_entrenamientos1_idx')
                ->references('id')->on('entrenamientos')
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
       Schema::dropIfExists($this->tableName);
     }
}
