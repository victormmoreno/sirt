<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineastecnologicasNodosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'lineastecnologicas_nodos';

    /**
     * Run the migrations.
     * @table lineastecnologicas_nodos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('lineatecnologica_id');
            $table->unsignedInteger('nodo_id');
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_lineastecnologicas_has_nodos_nodos1_idx');

            $table->index(["lineatecnologica_id"], 'fk_lineastecnologicas_has_nodos_lineastecnologicas1_idx');


            $table->foreign('lineatecnologica_id', 'fk_lineastecnologicas_has_nodos_lineastecnologicas1_idx')
                ->references('id')->on('lineastecnologicas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('nodo_id', 'fk_lineastecnologicas_has_nodos_nodos1_idx')
                ->references('id')->on('nodos')
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
