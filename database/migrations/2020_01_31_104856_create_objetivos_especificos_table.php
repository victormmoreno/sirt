<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjetivosEspecificosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'objetivos_especificos';
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
            $table->unsignedInteger('actividad_id');
            $table->string('objetivo', 500);
            $table->timestamps();

            $table->index(["actividad_id"], 'fk_objetivos_especificos_actividades1_idx');

            $table->foreign('actividad_id', 'fk_objetivos_especificos_actividades1_idx')
            ->references('id')->on('actividades')
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
