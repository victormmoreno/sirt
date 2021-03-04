<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompromisosToUsoinfraestructurasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usoinfraestructuras', function (Blueprint $table) {
            $table->string('compromisos', 2400)->nullable()->after('descripcion');
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
            $table->dropColumn(['compromisos']);
        });
    }
}
