<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodigoToUsoinfraestructurasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usoinfraestructuras', function (Blueprint $table) {
            $table->string('codigo', 50)->unique()->nullable()->after('asesorable_id'); //codigo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usoinfraestructuras', function (Blueprint $table) {
            $table->dropColumn(['codigo']);
        });
    }
}
