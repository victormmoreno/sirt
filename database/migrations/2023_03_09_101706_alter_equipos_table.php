<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEquiposTable extends Migration
{
    public $tableName = 'equipos';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->tinyInteger('destacado')->default(0)->after('lineatecnologica_id');
            $table->string('codigo', 50)->default(0)->after('destacado');
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
            $table->dropColumn(['destacado']);
            $table->dropColumn(['codigo']);
        });
    }
}
