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
            $table->unsignedInteger('centro_id');
            $table->string('nombre',100);
            $table->string('direccion', 200)->nullable();
            $table->year('anho_inicio');
            $table->timestamps();
            $table->index(["centro_id"], 'fk_nodos_centros1_idx');

            $table->unique(["nombre"], 'nombre_UNIQUE');


            $table->foreign('centro_id', 'fk_nodos_centros1_idx')
                ->references('id')->on('centros');
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
