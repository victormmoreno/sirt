<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallelineaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'detallelinea';

    /**
     * Run the migrations.
     * @table detallelinea
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idlinea')->unsigned();
            $table->integer('idnodo')->unsigned();
            $table->tinyInteger('estado')->default('1');

            $table->index(["idnodo"], 'fk_linea_has_nodo_nodo1_idx');

            $table->index(["idlinea"], 'fk_linea_has_nodo_linea1_idx');


            $table->foreign('idlinea', 'detallelinea_idlinea')
                ->references('idlinea')->on('linea');
                

            $table->foreign('idnodo', 'fk_linea_has_nodo_nodo1_idx')
                ->references('idnodo')->on('nodo');
                
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
