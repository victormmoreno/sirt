<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEtniaIdToUsersTable extends Migration
{

    public $tableName = 'users';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->unsignedInteger('etnia_id')->nullable()->after('ciudad_expedicion_id');

            $table->index(["etnia_id"], 'fk_etnia_id_users_uso1_idx');

            $table->foreign('etnia_id', 'fk_etnia_id_users_uso1_idx')
                ->references('id')->on('etnias');
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
            $table->dropColumn(['etnia_id']);
        });
    }
}
