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
            $table->unsignedInteger('areaconocimiento_id');
            $table->unsignedInteger('gestor_id');
            $table->unsignedInteger('entidad_id');
            $table->string('nombre', 100);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->string('observaciones',1000)->nullable();
            $table->integer('empleados')->nullable()->default('0');
            $table->integer('instructores')->nullable()->default('0');
            $table->integer('aprendices')->nullable()->default('0');
            $table->integer('publico')->nullable()->default('0');
            $table->tinyInteger('fotografias')->nullable()->default('0');
            $table->string('dir_fotografias',1000)->nullable();
            $table->tinyInteger('listado_asistencia')->nullable()->default('0');
            $table->string('dir_listado_asistencia',1000)->nullable();
            $table->tinyInteger('informe_final')->nullable()->default('0');
            $table->string('dir_informe_final',1000)->nullable();
            $table->timestamps();

            $table->index(["entidad_id"], 'fk_edts_entidades1_idx');

            $table->index(["areaconocimiento_id"], 'fk_edts_areasconocimiento1_idx');

            $table->index(["gestor_id"], 'fk_edts_gestores1_idx');


            $table->foreign('areaconocimiento_id', 'fk_edts_areasconocimiento1_idx')
                ->references('id')->on('areasconocimiento')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gestor_id', 'fk_edts_gestores1_idx')
                ->references('id')->on('gestores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('entidad_id', 'fk_edts_entidades1_idx')
                ->references('id')->on('entidades')
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
