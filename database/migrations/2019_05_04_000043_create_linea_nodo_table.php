<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineaNodoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'linea_nodo';

    /**
     * Run the migrations.
     * @table linea_nodo
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('lineas_id')->unsigned();
            $table->integer('nodos_id')->unsigned();
            $table->timestamps();

            $table->index(["nodos_id"], 'fk_linea_nodo_nodos1_idx');

            $table->index(["lineas_id"], 'fk_linea_nodo_lineas1_idx');

            $table->foreign('lineas_id', 'fk_linea_nodo_lineas1_idx')
                ->references('id')->on('lineas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('nodos_id', 'fk_linea_nodo_nodos1_idx')
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
