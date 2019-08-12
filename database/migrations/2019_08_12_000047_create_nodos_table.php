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
            $table->unsignedInteger('entidad_id');
            $table->string('direccion', 200)->nullable()->default(null);
            $table->smallInteger('anho_inicio');

            $table->index(["centro_id"], 'fk_nodos_centros1_idx');

            $table->index(["entidad_id"], 'fk_nodos_entidades1_idx');
            $table->nullableTimestamps();


            $table->foreign('centro_id', 'fk_nodos_centros1_idx')
                ->references('id')->on('centros')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('entidad_id', 'fk_nodos_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
