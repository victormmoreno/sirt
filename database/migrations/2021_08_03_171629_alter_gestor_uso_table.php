<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGestorUsoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'gestor_uso';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('asesorable_type')->nullable()->after('usoinfraestructura_id');
            $table->integer('asesorable_id')->nullable()->unsigned()->after('asesorable_type');
            $table->index(["asesorable_type", "asesorable_id"], 'gestor_uso_asesorable_type_asesorable_id_index');
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
            $table->dropColumn(['asesorable_type', 'asesorable_type']);
        });
    }
}
