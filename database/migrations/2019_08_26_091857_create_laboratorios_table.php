<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratoriosTable extends Migration
{

    public $tableName = 'laboratorios';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('lineatecnologica_id');
            $table->string('nombre',45);
            $table->string('participacion_costos',20);
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_laboratorios_nodos1_idx');
            $table->index(["lineatecnologica_id"], 'fk_laboratorios_lineatecnologica1_idx');

            $table->foreign('nodo_id', 'fk_laboratorios_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('lineatecnologica_id', 'fk_laboratorios_lineatecnologica1_idx')
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
