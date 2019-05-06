<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoUserTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'contrato_user';

    /**
     * Run the migrations.
     * @table contrato_user
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('contratos_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->index(["contratos_id"], 'fk_contrato_user_contratos1_idx');

            $table->index(["user_id"], 'fk_contrato_user_users1_idx');

            $table->foreign('contratos_id', 'fk_contrato_user_contratos1_idx')
                ->references('id')->on('contratos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_contrato_user_users1_idx')
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
