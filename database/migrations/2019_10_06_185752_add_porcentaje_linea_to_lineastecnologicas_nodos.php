<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPorcentajeLineaToLineastecnologicasNodos extends Migration
{

    public $tableName = 'lineastecnologicas_nodos';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->float('porcentaje_linea',20,2)->default(0)->after('nodo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $this->dropColumn(['porcentaje_linea']);
        });
    }
}
