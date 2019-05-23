<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestoresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'gestores';

    /**
     * Run the migrations.
     * @table gestores
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('salario', 11, 2);
            $table->string('profesion', 100);
            $table->unsignedInteger('tipovinculacion_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->index(["user_id"], 'fk_gestores_users1_idx');

            $table->index(["tipovinculacion_id"], 'fk_gestores_tiposvinculaciones1_idx');

            $table->foreign('tipovinculacion_id', 'fk_gestores_tiposvinculaciones1_idx')
                ->references('id')->on('tiposvinculaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_gestores_users1_idx')
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
