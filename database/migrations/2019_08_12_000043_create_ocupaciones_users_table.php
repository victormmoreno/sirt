<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcupacionesUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ocupaciones_users';

    /**
     * Run the migrations.
     * @table ocupaciones_users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('ocupacion_id');
            $table->unsignedInteger('user_id');

            $table->index(["ocupacion_id"], 'fk_ocupaciones_users_ocupaciones1_idx');

            $table->index(["user_id"], 'fk_ocupaciones_users_users1_idx');
            $table->nullableTimestamps();


            $table->foreign('ocupacion_id', 'fk_ocupaciones_users_ocupaciones1_idx')
                ->references('id')->on('ocupaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_ocupaciones_users_users1_idx')
                ->references('id')->on('users')
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
        Schema::dropIfExists($this->tableName);
    }
}
