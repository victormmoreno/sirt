<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostoadministrativoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'costoadministrativo';

    /**
     * Run the migrations.
     * @table costoadministrativo
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idcostoadministrativo');
            $table->integer('nodo')->unsigned();
            $table->string('nombre', 45)->nullable()->default(null);
            $table->string('valor', 45)->nullable()->default('0');

            $table->index(["nodo"], 'fk_costoadministrativo_nodo1_idx');


            $table->foreign('nodo', 'fk_costoadministrativo_nodo1_idx')
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
