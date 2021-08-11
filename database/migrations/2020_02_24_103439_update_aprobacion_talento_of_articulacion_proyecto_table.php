<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAprobacionTalentoOfArticulacionProyectoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'articulacion_proyecto';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->renameColumn('aprobacion_talento', 'aprobacion_dinamizador_ejecucion');
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
            $table->renameColumn('aprobacion_dinamizador_ejecucion', 'aprobacion_talento');
        });
    }
}
