<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodoTipoarticulacionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'nodo_tipoarticulacion';
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
            $table->unsignedBigInteger('tipo_articulacion_id');
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_tipoarticulacion_nodo_nodo1_idx');
            $table->index(["tipo_articulacion_id"], 'fk_tipoarticulacion_nodo_tipo_articulacion1_idx');


            $table->foreign('nodo_id', 'fk_tipoarticulacion_nodo_nodo1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipo_articulacion_id', 'fk_tipoarticulacion_nodo_tipo_articulacion1_idx')
                ->references('id')->on('tipo_articulaciones')
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
