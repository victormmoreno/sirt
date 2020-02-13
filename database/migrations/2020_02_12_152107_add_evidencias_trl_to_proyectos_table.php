<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvidenciasTrlToProyectosTable extends Migration
{

    public $tableName = 'proyectos';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('trl_prototipo', 300)->nullable()->default(null)->after('trl_obtenido');
            $table->string('trl_pruebas', 300)->nullable()->default(null)->after('trl_prototipo');
            $table->string('trl_modelo', 300)->nullable()->default(null)->after('trl_pruebas');
            $table->string('trl_normatividad', 300)->nullable()->default(null)->after('trl_modelo');
            $table->tinyInteger('evidencia_trl')->default(0)->after('trl_normatividad');
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
            $table->dropColumn(['trl_prototipo', 'trl_pruebas', 'trl_modelo', 'trl_normatividad', 'evidencia_trl']);
        });
    }
}
