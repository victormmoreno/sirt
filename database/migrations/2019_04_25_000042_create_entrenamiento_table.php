<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrenamientoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'entrenamiento';

    /**
     * Run the migrations.
     * @table entrenamiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('identrenamiento');
            $table->integer('idea')->unsigned();
            $table->tinyInteger('confirmacion');
            $table->dateTime('sesion1');
            $table->dateTime('sesion2');
            $table->tinyInteger('asistencia1')->nullable()->default(null);
            $table->tinyInteger('asistencia2')->nullable()->default(null);
            $table->tinyInteger('convocado')->nullable()->default(null);
            $table->tinyInteger('canvas')->nullable()->default(null);

            $table->index(["idea"], 'fk_entrenamiento_idea1_idx');


            $table->foreign('idea', 'fk_entrenamiento_idea1_idx')
                ->references('ididea')->on('idea')
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
