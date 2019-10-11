<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    public $tableName = 'equipos';
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
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('lineatecnologica_id');
            $table->string('referencia', 50);
            $table->string('nombre', 45);
            $table->string('marca', 45);
            $table->string('costo_adquisicion', 45)->default(0);
            $table->integer('vida_util')->default(0);
            $table->year('anio_compra');
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_nodo_equipos1_idx');
            $table->index(["lineatecnologica_id"], 'fk_lineatecnologica_equipos1_idx');

            $table->foreign('nodo_id', 'fk_nodo_equipos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('lineatecnologica_id', 'fk_lineatecnologica_equipos1_idx')
                ->references('id')->on('lineastecnologicas')
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
