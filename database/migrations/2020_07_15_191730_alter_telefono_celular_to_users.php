<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTelefonoCelularToUsers extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'users';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('celular', 20)->nullable()->default(null)->after('direccion')->change();
            $table->string('telefono', 20)->nullable()->default(null)->after('celular')->change();
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
            $table->dropColumn(['celular', 'telefono']);
        });
    }
}
