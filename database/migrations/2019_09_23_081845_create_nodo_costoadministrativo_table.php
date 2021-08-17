<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodoCostoadministrativoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'nodo_costoadministrativo';
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
            $table->unsignedInteger('costo_administrativo_id');
            $table->year('anho');
            $table->string('valor', 45);
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_nodo_costoadministrativo_nodo1_idx');
            $table->index(["costo_administrativo_id"], 'fk_nodo_costoadministrativo_costo_administrativo1_idx');

            $table->foreign('nodo_id', 'fk_nodo_costoadministrativo_nodo1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('costo_administrativo_id', 'fk_nodo_costoadministrativo_costo_administrativo1_idx')
                ->references('id')->on('costos_administrativos')
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
