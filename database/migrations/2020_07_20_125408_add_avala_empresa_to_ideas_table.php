<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvalaEmpresaToIdeasTable extends Migration
{
    public $tableName = 'ideas';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->tinyInteger('aval_empresa')->default(0)->after('convocatoria');
            $table->string('empresa', 100)->nullable()->default(null)->after('aval_empresa');
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
            $table->dropColumn(['aval_empresa', 'empresa']);
        });
    }
}
