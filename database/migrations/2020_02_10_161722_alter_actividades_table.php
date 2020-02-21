<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterActividadesTable extends Migration
{
    public $tableName = 'actividades';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->tinyInteger('formulario_inicio')->default(0)->after('fecha_cierre');
            $table->tinyInteger('cronograma')->default(0)->after('formulario_inicio');
            $table->tinyInteger('seguimiento')->default(0)->after('cronograma');
            $table->tinyInteger('evidencia_final')->default(0)->after('seguimiento');
            $table->tinyInteger('formulario_final')->default(0)->after('evidencia_final');
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
            $table->dropColumn(['formulario_inicio', 'cronograma', 'seguimiento', 'evidencia_final', 'formulario_final']);
        });
    }
}
