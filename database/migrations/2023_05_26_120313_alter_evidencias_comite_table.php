<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEvidenciasComiteTable extends Migration
{
    public $tableName = 'comites';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->tinyInteger('acta')->default(0)->after('listado_asistencia');
            $table->tinyInteger('formato_evaluacion')->default(0)->after('acta');
            $table->dropColumn(['correos']);
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
            $table->dropColumn(['acta']);
            $table->dropColumn(['formato_evaluacion']);
            $table->tinyInteger('correos')->default(0)->after('observaciones');
        });
    }
}
