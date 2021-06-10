<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoVinculacionToArticulacionPbt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulacion_pbts', function (Blueprint $table) {
            $table->integer('tipo_vinculacion')->default(1)->after('id'); //defaul-pbt
            // $table->integer('proyecto_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articulacion_pbts', function (Blueprint $table) {
            $table->dropColumn(['tipo_vinculacion']);
        });
    }
}
