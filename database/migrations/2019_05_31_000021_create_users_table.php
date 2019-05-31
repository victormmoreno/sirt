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
            $table->unsignedInteger('rol_id');
            $table->unsignedInteger('gradoescolaridad_id');
            $table->integer('tipodocumento_id')->unsigned();
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('documento', 45);
            $table->string('email', 100);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('celular', 11)->nullable();
            $table->string('telefono', 11)->nullable();
            $table->date('fechanacimiento');
            $table->tinyInteger('genero');
            $table->tinyInteger('estado')->default('1');
            $table->rememberToken();
            $table->string('password', 255)->nullable();
            $table->tinyInteger('estrato')->nullable();

            $table->nullableTimestamps();


            $table->index(["rol_id"], 'fk_users_rols1_idx');

            $table->index(["gradoescolaridad_id"], 'fk_users_gradoescolaridad1_idx');

            $table->unique(["email"], 'email_UNIQUE');

            $table->foreign('rol_id', 'fk_users_rols1_idx')
                ->references('id')->on('rols')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gradoescolaridad_id', 'fk_users_gradoescolaridad1_idx')
                ->references('id')->on('gradosescolaridad')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipodocumento_id')->references('id')
                ->on('tiposdocumentos')
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
