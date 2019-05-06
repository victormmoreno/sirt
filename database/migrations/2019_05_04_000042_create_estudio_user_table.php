<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudioUserTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'estudio_user';

    /**
     * Run the migrations.
     * @table estudio_user
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fechaterminacion')->nullable();
            $table->string('institucion')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('estudio_id')->unsigned();
            $table->timestamps();

            $table->index(["estudio_id"], 'fk_estudio_user_estudios1_idx');

            $table->index(["user_id"], 'fk_estudio_user_users1_idx');

            $table->foreign('user_id', 'fk_estudio_user_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('estudio_id', 'fk_estudio_user_estudios1_idx')
                ->references('id')->on('estudios')
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
