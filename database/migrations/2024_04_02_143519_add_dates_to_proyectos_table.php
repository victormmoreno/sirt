<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatesToProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dateTime('fecha_inicio_planeacion')->nullable()->default(null)->after('fecha_inicio');
            $table->dateTime('fecha_inicio_ejecucion')->nullable()->default(null)->after('fecha_inicio_planeacion');
            $table->dateTime('fecha_inicio_cierre')->nullable()->default(null)->after('fecha_inicio_ejecucion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropColumn(['fecha_inicio_planeacion', 'fecha_inicio_ejecucion', 'fecha_inicio_cierre']);
        });
    }
}
