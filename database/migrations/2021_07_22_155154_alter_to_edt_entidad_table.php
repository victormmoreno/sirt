<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterToEdtEntidadTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'edt_entidad';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('edtable_type')->nullable()->after('id');
            $table->integer('edtable_id')->nullable()->unsigned()->after('id');
            $table->index(["edtable_type", "edtable_id"], 'edt_entidad_edtable_type_edtable_id_index');
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
                $table->dropColumn(['edtable_type', 'edtable_id']);
        });
    }
}
