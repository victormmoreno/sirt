<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'nodos';

    /**
     * Run the migrations.
     * @table nodos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('centro_id')->unsigned();
            $table->string('nombre');
            $table->string('direccion', 200)->nullable();
            $table->timestamps();
            $table->unique(["nombre"], 'nombre_UNIQUE');

            $table->index(["centro_id"], 'fk_nodos_centros1_idx');

            $table->foreign('centro_id', 'fk_nodos_centros1_idx')
                ->references('id')->on('centros')
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
