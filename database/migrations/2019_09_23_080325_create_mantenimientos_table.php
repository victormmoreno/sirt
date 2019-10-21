<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantenimientosTable extends Migration
{

    public $tableName = 'mantenimientos';
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
            $table->unsignedBigInteger('laboratorio_id');
            $table->string('item',200);
            $table->string('precio',45);
            $table->string('vida_util',45);
            $table->string('anho_ultimo_mantenimiento',45);
            $table->string('horas_uso',45);
            $table->timestamps();

            $table->index(["laboratorio_id"], 'fk_mantenimiento_laboratorio1_idx');

            $table->foreign('laboratorio_id', 'fk_mantenimiento_laboratorio1_idx')
                ->references('id')->on('laboratorios')
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
