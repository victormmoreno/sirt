<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicacionesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'publicaciones';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->string('codigo_publicacion', 20);
            $table->string('titulo', 50);
            $table->string('contenido', 1000);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->tinyInteger('estado');
            $table->timestamps();

            $table->index(["user_id"], 'fk_publicacion_user1_idx');

            $table->index(["role_id"], 'fk_publicacion_role1_idx');

            $table->foreign('user_id', 'fk_publicacion_user1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('role_id', 'fk_publicacion_role1_idx')
                ->references('id')->on('roles')
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
