<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('documento');
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('direccion', 200)->nullable();
            $table->integer('telefono')->nullable();
            $table->integer('celular')->nullable();
            $table->date('fechanacimiento')->nullable();
            $table->text('descripcion_ocupacion')->nullable();
            $table->string('password')->nullable();
            $table->integer('genero_id')->unsigned();
            $table->integer('tipodocumento_id')->unsigned();
            $table->integer('ciudad_id')->unsigned();
            $table->integer('rol_id')->unsigned();
            $table->integer('ocupacion_id')->unsigned();
            $table->integer('estrato_id')->unsigned();

            $table->index(["ocupacion_id"], 'fk_users_ocupaciones1_idx');

            $table->index(["ciudad_id"], 'fk_users_ciudades1_idx');

            $table->index(["tipodocumento_id"], 'fk_users_tiposdocumentos1_idx');

            $table->index(["estrato_id"], 'fk_users_estratos1_idx');

            $table->index(["rol_id"], 'fk_users_roles1_idx');

            $table->index(["genero_id"], 'fk_users_genero1_idx');

            $table->unique(["documento"], 'documento_UNIQUE');

            $table->unique(["email"], 'email_UNIQUE');
            $table->timestamps();

            $table->foreign('genero_id', 'fk_users_genero1_idx')
                ->references('id')->on('generos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipodocumento_id', 'fk_users_tiposdocumentos1_idx')
                ->references('id')->on('tiposdocumentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ciudad_id', 'fk_users_ciudades1_idx')
                ->references('id')->on('ciudades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('rol_id', 'fk_users_roles1_idx')
                ->references('id')->on('roles')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ocupacion_id', 'fk_users_ocupaciones1_idx')
                ->references('id')->on('ocupaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('estrato_id', 'fk_users_estratos1_idx')
                ->references('id')->on('estratos')
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
