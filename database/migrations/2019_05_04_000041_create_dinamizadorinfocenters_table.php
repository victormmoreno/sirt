<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDinamizadorinfocentersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'dinamizadorinfocenters';

    /**
     * Run the migrations.
     * @table dinamizadorinfocenters
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('honorario', 11, 2)->default(0);
            $table->string('profesion', 100);
            $table->integer('tipovinculacion_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->index(["user_id"], 'fk_dinamizadorinfocenters_users1_idx');

            $table->index(["tipovinculacion_id"], 'fk_dinamizadorinfocenters_tiposvinculaciones1_idx');

            $table->foreign('tipovinculacion_id', 'fk_dinamizadorinfocenters_tiposvinculaciones1_idx')
                ->references('id')->on('tiposvinculaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_dinamizadorinfocenters_users1_idx')
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
