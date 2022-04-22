<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMetasNodo extends Migration
{
    public $tableName = 'metas_nodo';
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
            $table->integer('nodo_id')->unsigned();
            $table->year('anho');
            $table->integer('articulaciones');
            $table->integer('trl6');
            $table->integer('trl7_trl8');
            $table->timestamps();

            $table->foreign('nodo_id')->references('id')->on('nodos');
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
