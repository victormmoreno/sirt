<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterTableResultadosEncuesta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('movimientos')->where('movimiento', 'envió la encuesta de satisfacción')->update(['movimiento' => 'envió la encuesta de percepción']);
        DB::table('movimientos')->where('movimiento', 'respondió la encuesta de satisfacción')->update(['movimiento' => 'respondió la encuesta de percepción']);
        Schema::table('resultados_encuesta', function (Blueprint $table) {
            $table->tinyInteger('estado')->default(1)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('movimientos')->where('movimiento', 'envió la encuesta de percepción')->update(['movimiento' => 'envió la encuesta de satisfacción']);
        DB::table('movimientos')->where('movimiento', 'respondió la encuesta de percepción')->update(['movimiento' => 'respondió la encuesta de satisfacción']);
        Schema::table('resultados_encuesta', function (Blueprint $table) {
            $table->dropColumn(['estado']);
        });
    }
}
