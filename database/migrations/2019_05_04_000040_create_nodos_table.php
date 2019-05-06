<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('nombre');
            $table->string('direccion', 200)->nullable();
            $table->unsignedInteger('centroformacion_id');

            $table->index(["centroformacion_id"], 'fk_nodos_centrosformacion1_idx');

            $table->unique(["nombre"], 'nombre_UNIQUE');
            $table->timestamps();

            $table->foreign('centroformacion_id', 'fk_nodos_centrosformacion1_idx')
                ->references('id')->on('centrosformacion')
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
