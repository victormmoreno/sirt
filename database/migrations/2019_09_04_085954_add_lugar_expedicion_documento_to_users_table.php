<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLugarExpedicionDocumentoToUsersTable extends Migration
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

            $table->unsignedInteger('ciudad_expedicion_id')->after('ciudad_id');

            $table->index(["ciudad_expedicion_id"], 'fk_users_ciudad_expedicion1_idx');

            $table->foreign('ciudad_expedicion_id', 'fk_users_ciudad_expedicion1_idx')
                ->references('id')->on('ciudades')
                ->onDelete('no action')
                ->onUpdate('no action');
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
            $table->dropForeign('ciudad_expedicion_id');
            $table->dropColumn(['ciudad_expedicion_id']);
        });
    }
}
