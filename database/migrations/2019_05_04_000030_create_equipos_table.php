<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'equipos';

    /**
     * Run the migrations.
     * @table equipos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 200);
            $table->string('serial', 45)->nullable();
            $table->string('modelo', 45)->nullable();
            $table->string('marca', 45)->nullable();
            $table->string('placa_senal', 45)->nullable();
            $table->tinyInteger('estado')->nullable();
            $table->integer('linea_id')->unsigned();
            $table->integer('fichatecnica_id')->unsigned();
            $table->timestamps();

            $table->index(["linea_id"], 'fk_equipos_lineas1_idx');

            $table->index(["fichatecnica_id"], 'fk_equipos_fichastecnicas1_idx');

            $table->foreign('linea_id', 'fk_equipos_lineas1_idx')
                ->references('id')->on('lineas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('fichatecnica_id', 'fk_equipos_fichastecnicas1_idx')
                ->references('id')->on('fichastecnicas')
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
