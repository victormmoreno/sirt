<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'equipo';

    /**
     * Run the migrations.
     * @table equipo
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_equipo');
            $table->string('nombre_equipo', 100)->nullable()->default(null);
            $table->string('serial', 45)->nullable()->default(null);
            $table->string('modelo', 45)->nullable()->default(null);
            $table->string('marca', 45)->nullable()->default(null);
            $table->string('placa_sena', 45)->nullable()->default(null);
            $table->tinyInteger('estado')->nullable()->default(null);
            $table->integer('linea_equipo')->unsigned();
            $table->integer('ficha_tecnica')->unsigned();

            $table->index(["ficha_tecnica"], 'fk_equipo_ficha_tecnica1_idx');

            $table->index(["linea_equipo"], 'fk_equipo_linea1_idx');


            $table->foreign('ficha_tecnica', 'fk_equipo_ficha_tecnica1_idx')
                ->references('id_ficha')->on('ficha_tecnica')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('linea_equipo', 'fk_equipo_linea1_idx')
                ->references('idlinea')->on('linea')
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
