<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdtsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'edts';

    /**
     * Run the migrations.
     * @table edts
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('actividad_id');
            $table->unsignedInteger('areaconocimiento_id');
            $table->unsignedInteger('tipoedt_id');
            $table->string('observaciones')->nullable()->default(null);
            $table->integer('empleados')->nullable()->default('0');
            $table->integer('instructores')->nullable()->default('0');
            $table->integer('aprendices')->nullable()->default('0');
            $table->integer('publico')->nullable()->default('0');
            $table->tinyInteger('estado')->default('1');
            $table->tinyInteger('fotografias')->nullable()->default('0');
            $table->tinyInteger('listado_asistencia')->nullable()->default('0');
            $table->tinyInteger('informe_final')->nullable()->default('0');

            $table->index(["areaconocimiento_id"], 'fk_edts_areasconocimiento1_idx');

            $table->index(["tipoedt_id"], 'fk_edts_tiposedt1_idx');

            $table->index(["actividad_id"], 'fk_edts_actividades1_idx');
            $table->nullableTimestamps();


            $table->foreign('actividad_id', 'fk_edts_actividades1_idx')
                ->references('id')->on('actividades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('areaconocimiento_id', 'fk_edts_areasconocimiento1_idx')
                ->references('id')->on('areasconocimiento')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipoedt_id', 'fk_edts_tiposedt1_idx')
                ->references('id')->on('tiposedt')
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
