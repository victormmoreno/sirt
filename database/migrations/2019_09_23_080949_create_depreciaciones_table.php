<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepreciacionesTable extends Migration
{

    public $tableName = 'depreciaciones';
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
            $table->string('equipo',45);
            $table->string('marca',45);
            $table->string('referencia',45);
            $table->string('costo',45);
            $table->string('vida_util',45);
            $table->integer('anho')->nullable();
            $table->string('horas_uso',45)->nullable();
            $table->timestamps();

            $table->index(["laboratorio_id"], 'fk_depreciacion_laboratorio1_idx');

            $table->foreign('laboratorio_id', 'fk_depreciacion_laboratorio1_idx')
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
