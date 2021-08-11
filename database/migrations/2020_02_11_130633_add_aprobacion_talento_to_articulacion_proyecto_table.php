<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAprobacionTalentoToArticulacionProyectoTable extends Migration
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
            $table->tinyInteger('aprobacion_talento')->default(0)->after('actividad_id');
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
            $table->dropColumn(['aprobacion_talento']);
        });
    }
}
