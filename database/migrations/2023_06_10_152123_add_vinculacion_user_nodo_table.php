<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVinculacionUserNodoTable extends Migration
{
    public $tableName = 'user_nodo';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->tinyInteger('vinculacion')->default('0')->after('role');
            //DB::statement('ALTER TABLE `user` MODIFY `user_id` INTEGER UNSIGNED NULL;')
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
            $table->dropColumn(['vinculacion']);
        });
    }
}
