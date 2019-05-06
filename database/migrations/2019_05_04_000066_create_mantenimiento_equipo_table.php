<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientoEquipoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'mantenimiento_equipo';

    /**
     * Run the migrations.
     * @table mantenimiento_equipo
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tipo_mantenimiento_equipo')->nullable();
            $table->unsignedInteger('mantenimiento_id');
            $table->unsignedInteger('equipo_id');
            $table->unsignedInteger('contrato_id');
            $table->timestamps();

            $table->index(["mantenimiento_id"], 'fk_mantenimiento_equipo_mantenimientos1_idx');

            $table->index(["equipo_id"], 'fk_mantenimiento_equipo_equipos1_idx');

            $table->index(["contrato_id"], 'fk_mantenimiento_equipo_contratos1_idx');

            $table->foreign('mantenimiento_id', 'fk_mantenimiento_equipo_mantenimientos1_idx')
                ->references('id')->on('mantenimientos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('equipo_id', 'fk_mantenimiento_equipo_equipos1_idx')
                ->references('id')->on('equipos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('contrato_id', 'fk_mantenimiento_equipo_contratos1_idx')
                ->references('id')->on('contratos')
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
